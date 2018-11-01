<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Running extends Model
{
    protected $table = 'running';
    const UPDATED_AT = 'last_update';

    public function Branch()
    {
        return $this->hasOne('App\Models\Branch', 'con_id', 'branch_id');
    }

    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'con_id', 'cat_id');
    }
}