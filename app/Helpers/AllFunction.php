<?php

namespace App\Helpers;

class AllFunction
{
    public function convertDateFormat($val)
    {
        $a = explode("/", $val);
        $value = $a[2] . "-" . $a[1] . "-" . $a[0];
        return $value;
    }
}