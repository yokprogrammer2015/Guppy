<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BestSeller extends Model
{
    protected $table = 'best_seller';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'con_id', 'cat_id');
    }

    public function Departure()
    {
        return $this->hasOne('App\Models\Route', 'con_id', 'dep_id');
    }

    public function Arrive()
    {
        return $this->hasOne('App\Models\Route', 'con_id', 'arr_id');
    }

    public function Time()
    {
        return $this->hasOne('App\Models\Time', 'con_id', 'time_id');
    }

    public function TimeTo()
    {
        return $this->hasOne('App\Models\Time', 'con_id', 'time_to_id');
    }

    public function grandTotal($travel_date, $dep_id, $arr_id)
    {
        $order = DB::table('order')->where('travel_date', $travel_date)->where('dep_id', $dep_id)->where('arr_id', $arr_id)->count();
        return $order;
    }
}