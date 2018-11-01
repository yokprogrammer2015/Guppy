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

        if ($permissions == 2 && ($px == 'Manage Admin' || $px == 'Manage Config')) {
            return false;
        }

        return true;
    }
}