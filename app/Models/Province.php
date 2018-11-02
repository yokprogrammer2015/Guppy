<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    public function Amphure()
    {
        return $this->hasMany('App\Models\Amphure', 'province_id', 'id');
    }
}