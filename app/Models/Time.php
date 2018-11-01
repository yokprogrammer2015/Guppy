<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $table = 'time';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}