<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (isset($item['text']) && !$this->can($item['text'])) {
            return false;
        }

        return $item;
    }

    private function can($px)
    {
        $permissions = session('mb_type');
        if ($permissions) {
            if ($permissions == 2 && ($px == 'รายการสินค้า' || $px == 'จัดการผู้ใช้' || $px == 'ตั้งค่า')) {
                return false;
            } else {
                if ($px == 'รายการสินค้า') {
                    return false;
                }
            }
            return true;
        } else {
            if ($px == 'รายการ' || $px == 'เพิ่มรายการ' || $px == 'จัดการผู้ใช้' || $px == 'ตั้งค่า') {
                return false;
            }
            return true;
        }
    }
}