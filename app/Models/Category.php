<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}