<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';
    protected $setData;
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function Member()
    {
        return $this->hasOne('App\Models\Member', 'mb_id', 'mb_id');
    }

    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'cat_id');
    }

    public function genRunning()
    { // ex 18110001
        $order = DB::table('order')->select('id')->orderBy('id', 'desc')->first();
        if ($order) {
            $this->setData = date('ym') . str_pad($order->id + 1, 4, 0, STR_PAD_LEFT);
        } else {
            $this->setData = date('ym') . str_pad(1, 4, 0, STR_PAD_LEFT);
        }

        return $this->setData;
    }
}