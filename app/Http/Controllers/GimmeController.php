<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Http\Resources\RegistryRecordResource;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\RegistryRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GimmeController extends Controller
{
    // Не работают оплаты другие
    // Сумма начислено - считаем ли неактивные реестры, оплаченные суммы?
    // Сумма Оплачено всего - считаем ли возвраты
    public function index(Request $request)
    {
        $account_number = $request->query()['НомерЛицевого'];
        $provider_id = $request->query()['IdПоставщика'];
        // $additional_payments = DB::select('EXEC платежи.ОплатыДругие');      
        return json_encode([
            'Номер лицевого счета' => $account_number,
            'Id Поставщика' => $provider_id,
            'Название поставщика' => Provider::where('КодКонтрагента_ID', $provider_id)->first()->Название,
            'Сумма начислено' => RegistryRecord::where('НомерЛицевого', $account_number)->where('КодПоставщика_IDX', $provider_id)->sum('СуммаНачислено'),
            'Сумма Оплачено всего' => Payment::where('НомерЛицевого', $account_number)->sum('СуммаОплаты'),
            'Оплаты по типам оплат' => [
                'Оплачено наличными' => Payment::where('НомерЛицевого', $account_number)->where('ТипОплаты_IDX', 1)->sum('СуммаОплаты'),
                'Оплачено безналичными' => Payment::where('НомерЛицевого', $account_number)->where('ТипОплаты_IDX', 2)->sum('СуммаОплаты')
            ],
            'Использованные в расчетах оплаты' => PaymentResource::collection(Payment::where('НомерЛицевого', $account_number)->get()),
            'Участвующие в расчетах записи реестров' => RegistryRecordResource::collection(RegistryRecord::where('НомерЛицевого', $account_number)->where('КодПоставщика_IDX', $provider_id)->get())
        ], JSON_UNESCAPED_UNICODE);
    }
}
