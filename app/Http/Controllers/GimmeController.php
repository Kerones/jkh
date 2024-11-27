<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Http\Resources\RegistryRecordResource;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\RegistryRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GimmeController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'НомерЛицевого' => 'required',
            'IdПоставщика' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Укажите НомерЛицевого и IdПоставщика'], 401, options: JSON_UNESCAPED_UNICODE);
        }


        $account_number = $request->query()['НомерЛицевого'];
        $provider_id = $request->query()['IdПоставщика'];
        $cacheKey = $account_number . $provider_id;
        if (Cache::has($cacheKey)) {
            $result = Cache::get($cacheKey);
        } else {
            $payments = collect(Payment::where('НомерЛицевого', $account_number)
                ->where('ОплатаЗакрыта', 1)
                ->whereHas('registryRecord', function ($query) use ($provider_id) {
                    return $query->where('КодПоставщика_IDX', $provider_id);
                })
                ->whereNull('ЭтоВозвратОплаты_IDX')
                ->unRefunded()
                ->get());

            $additional_payments = DB::select('exec платежи.ОплатыДругие');
            $additional_payments = collect($additional_payments)
                ->where('НомерЛицевого', $account_number)
                ->where('ОплатаЗакрыта', 1)
                ->whereNull('ЭтоВозвратОплаты_IDX')
                ->whereIn('КодЗаписиРеестра_IDX', RegistryRecord::where('КодПоставщика_IDX', $provider_id)
                    ->pluck('КодЗаписиРеестра_ID'));
            $payments = $payments->merge($additional_payments);
            $registryRecordsQuery = RegistryRecord::where('НомерЛицевого', $account_number)->where('КодПоставщика_IDX', $provider_id)->activeRegistry();
            $bankPaid = $payments->where('ТипОплаты_IDX', 2)->sum('СуммаОплаты');
            $cashPaid =  $payments->where('ТипОплаты_IDX', 1)->sum('СуммаОплаты');
            $sumPaid = $cashPaid + $bankPaid;
            $toPay = $registryRecordsQuery->sum('СуммаНачислено');
            
            $result = [
                'Номер лицевого счета' => $account_number,
                'Id поставщика' => $provider_id,
                'Название поставщика' => Provider::where('КодКонтрагента_ID', $provider_id)->first()->Название,
                'Сумма начислено' => $toPay,
                'Сумма Оплачено всего' => $sumPaid,
                'Оплаты по типам оплат' => [
                    'Оплачено наличными' => $cashPaid,
                    'Оплачено безналичными' => $bankPaid
                ],
                'Cумма к оплате' => $toPay - $sumPaid,
                'Использованные в расчетах оплаты' => PaymentResource::collection($payments),
                'Участвующие в расчетах записи реестров' => RegistryRecordResource::collection($registryRecordsQuery->get())
            ];
            Cache::add($cacheKey, $result, 60);
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
