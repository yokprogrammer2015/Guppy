<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}