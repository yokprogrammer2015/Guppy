<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}
