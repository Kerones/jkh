<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'платежи.Оплаты';

    public function registryRecord()
    {
        return $this->belongsTo(RegistryRecord::class, 'КодЗаписиРеестра_IDX', 'КодЗаписиРеестра_ID');
    }

    public function scopeUnrefunded(Builder $query)
    {
        $query->whereNotIn('КодОплаты_Id', function ($query) {
            $query->select('ЭтоВозвратОплаты_IDX')
                ->from('платежи.Оплаты')
                ->whereNotNull('ЭтоВозвратОплаты_IDX');
        });
    }
}
