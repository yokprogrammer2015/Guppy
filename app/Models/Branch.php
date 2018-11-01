<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function Route()
    {
        return $this->hasOne('App\Models\Route', 'con_id', 'rou_id');
    }
}