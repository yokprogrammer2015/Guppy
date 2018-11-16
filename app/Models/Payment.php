<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $status;
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function Customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function Booking()
    {
        return $this->hasOne('App\Models\Booking', 'id', 'booking_id');
    }

    public function Transport()
    {
        return $this->hasOne('App\Models\Transport', 'id', 'transport_id');
    }

    public function getStatus($status)
    {
        if ($status == 'Y') {
            $this->status = '<span class="badge bg-green">รอรับสินค้า</span>';
        } else {
            $this->status = '<span class="badge bg-red">ปิดการขาย</span>';
        }

        return $this->status;
    }
}