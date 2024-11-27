<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'справочники.Контрагенты';

    public function registries()
    {
        return $this->hasMany(Registry::class, 'КодКонтрагента_IDX', 'КодКонтрагента_ID');
    }
}
