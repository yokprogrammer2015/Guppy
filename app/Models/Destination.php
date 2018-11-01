<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destination';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function route()
    {
        return $this->belongsTo('App\Models\Route', 'con_id', 'rou_id');
    }

    public function getNameAttribute(){
        return $this->con_name;
    }

    public function getIdAttribute(){
        return $this->con_id;
    }
}