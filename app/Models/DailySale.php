<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    protected $table = 'daily_sale';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}