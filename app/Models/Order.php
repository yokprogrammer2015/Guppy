<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'con_id', 'cat_id');
    }

    public function Branch()
    {
        return $this->hasOne('App\Models\Branch', 'con_id', 'branch_id');
    }

    public function ServiceBranch()
    {
        return $this->hasOne('App\Models\Branch', 'rou_id', 'dep_id');
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

    public function PickUp()
    {
        return $this->hasOne('App\Models\Destination', 'con_id', 'pick_id');
    }

    public function DropOff()
    {
        return $this->hasOne('App\Models\Destination', 'con_id', 'drop_id');
    }

    public function Agent()
    {
        return $this->hasOne('App\Models\Agent', 'ag_id', 'ag_id');
    }

    public function Member()
    {
        return $this->hasOne('App\Models\Member', 'mb_id', 'mb_id');
    }

    public function DailySale()
    {
        return $this->hasOne('App\Models\DailySale', 'order_id', 'order_id');
    }

    public function InvoiceDetail()
    {
        return $this->hasOne('App\Models\InvoiceDetail', 'order_id', 'order_id');
    }
}