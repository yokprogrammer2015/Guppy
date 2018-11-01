<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'route';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';


    protected $primaryKey = 'con_id';

    public function Destination()
    {
        return $this->hasMany('App\Models\Destination', 'rou_id', 'con_id');
    }
}