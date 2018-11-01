<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_detail';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function getAmount($inv_id = null)
    {
        $amount = 0;
        $invoiceDetail = DB::table('invoice_detail')->where('inv_id', $inv_id)->get();
        foreach ($invoiceDetail as $row) {
            $order = DB::table('order')->where('order_id', $row->order_id)->get();
            foreach ($order as $row2) {
                $total = (int)($row2->adult * $row2->price_adult) + ($row2->child * $row2->price_child);
                $amount += $total;
            }
        }
        return $amount;
    }

    public function Invoice()
    {
        return $this->hasOne('App\Models\Invoice', 'inv_id', 'inv_id');
    }

    public function Order()
    {
        return $this->hasOne('App\Models\Order', 'order_id', 'order_id');
    }

    public function DailySale()
    {
        return $this->hasOne('App\Models\DailySale', 'ds_id', 'ds_id');
    }

    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'con_id', 'cat_id');
    }

    public function Route()
    {
        return $this->hasOne('App\Models\Route', 'con_id', 'rou_id');
    }

    public function RouteTo()
    {
        return $this->hasOne('App\Models\Route', 'con_id', 'rou_id_to');
    }
}