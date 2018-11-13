<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}
