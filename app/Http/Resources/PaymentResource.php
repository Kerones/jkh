<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (isset($this->КодОплаты_ID)) {
            return [
                'КодОплаты_ID' => $this->КодОплаты_ID,
                'НомерЛицевого' => $this->НомерЛицевого,
                'СуммаОплаты' => $this->СуммаОплаты,
                'ЭтоВозвратОплаты_IDX' => $this->ЭтоВозвратОплаты_IDX,
                'КодЗаписиРеестра_IDX' => $this->КодЗаписиРеестра_IDX,
                'ОплатаЗакрыта' => $this->ОплатаЗакрыта
            ];
        }
        return [
            'НомерЛицевого' => $this->НомерЛицевого,
            'СуммаОплаты' => $this->СуммаОплаты,
            'ЭтоВозвратОплаты_IDX' => $this->ЭтоВозвратОплаты_IDX,
            'КодЗаписиРеестра_IDX' => $this->КодЗаписиРеестра_IDX,
            'ОплатаЗакрыта' => $this->ОплатаЗакрыта
        ];
    }
}
