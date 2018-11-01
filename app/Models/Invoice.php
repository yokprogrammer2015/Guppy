<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function InvoiceDetail()
    {
        return $this->hasOne('App\Models\InvoiceDetail', 'inv_id', 'inv_id');
    }

    public function Agent()
    {
        return $this->hasOne('App\Models\Agent', 'ag_id', 'ag_id');
    }

    public function badge($type = null)
    {
        switch ($type) {
            case 'Cash':
                $bg = 'badge bg-green';
                break;
            case 'Check':
                $bg = 'badge bg-red';
                break;
            case 'Credit':
                $bg = 'badge bg-yellow';
                break;
            default:
                $bg = 'badge bg-green';
        }
        return $bg;
    }
}