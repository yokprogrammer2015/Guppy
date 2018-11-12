<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}