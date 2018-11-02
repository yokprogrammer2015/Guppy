<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amphure extends Model
{
    protected $table = 'amphures';

    public function District()
    {
        return $this->hasMany('App\Models\District', 'amphure_id', 'id');
    }
}