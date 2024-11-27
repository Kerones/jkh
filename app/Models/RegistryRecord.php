<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistryRecord extends Model
{
    use HasFactory;

    protected $table = 'реестры.РеестрыЗаписи';

    public function registry()
    {
        return $this->belongsTo(Registry::class, 'КодРеестра_IDX', 'КодРеестра_ID');
    }

    public function scopeActiveRegistry(Builder $query)
    {
        $query->whereHas('registry', function ($query) {
            return $query->where('РеестрАктивен', 1);
        });
    }
}
