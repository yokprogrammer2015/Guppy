<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function Branch()
    {
        return $this->hasOne('App\Models\Branch', 'con_id', 'branch_id');
    }

    public function MemberType()
    {
        return $this->hasOne('App\Models\MemberType', 'con_id', 'type_id');
    }

    public function Status($type = 0, $label = null)
    {
        switch ($type) {
            case 0 :
                $label = '<label class="badge bg-green">Active</label>';
                break;
            case 1:
                $label = '<label class="badge bg-red">Hide</label>';
                break;
        }
        return $label;
    }
}