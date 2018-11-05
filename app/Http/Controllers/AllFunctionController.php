<?php

namespace App\Http\Controllers;

use App\Models\Order;

class AllFunctionController extends Controller
{
    private $order;
    protected $running;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function DateFormat($val, $full)
    {
        $mon = "";
        $a = explode("-", $val);
        if ($full == "S" || $full == "s") {
            switch ($a[1]) {
                case "01" :
                    $mon = "Jan";
                    break;
                case "02" :
                    $mon = "Feb";
                    break;
                case "03" :
                    $mon = "Mar";
                    break;
                case "04" :
                    $mon = "Apr";
                    break;
                case "05" :
                    $mon = "May";
                    break;
                case "06" :
                    $mon = "Jun";
                    break;
                case "07" :
                    $mon = "Jul";
                    break;
                case "08" :
                    $mon = "Aug";
                    break;
                case "09" :
                    $mon = "Sep";
                    break;
                case "10" :
                    $mon = "Oct";
                    break;
                case "11" :
                    $mon = "Nov";
                    break;
                case "12" :
                    $mon = "Dec";
            }
        } else {
            switch ($a[1]) {
                case "01" :
                    $mon = "January";
                    break;
                case "02" :
                    $mon = "February";
                    break;
                case "03" :
                    $mon = "March";
                    break;
                case "04" :
                    $mon = "April";
                    break;
                case "05" :
                    $mon = "May";
                    break;
                case "06" :
                    $mon = "June";
                    break;
                case "07" :
                    $mon = "July";
                    break;
                case "08" :
                    $mon = "August";
                    break;
                case "09" :
                    $mon = "September";
                    break;
                case "10" :
                    $mon = "October";
                    break;
                case "11" :
                    $mon = "November";
                    break;
                case "12" :
                    $mon = "December";
            }
        }
        $value = "$a[2] $mon $a[0]";
        return $value;
    }

    public function convertDateFormat($val)
    {
        $a = explode("/", $val);
        $value = $a[2] . "-" . $a[0] . "-" . $a[1];
        return $value;
    }

    public function showDateFormat($val)
    {
        $a = explode("-", $val);
        $value = $a[1] . "/" . $a[2] . "/" . $a[0];
        return $value;
    }

    public function getStatusCode($code = null)
    {
        switch ($code) {
            case 'Y':
                $data = '<span class="label bg-green">เปิดใช้งาน</span>';
                break;
            default:
                $data = '<span class="label bg-red">ปิดใช้งาน</span>';
        }

        return $data;
    }

    public function bahtThai($thb)
    {
        $thb2 = list($thb) = explode('.', $thb);
        if (isset($thb2[1]) != null) {
            $ths_value = $thb2[1];
            echo $ths_value;
        } else {
            $ths_value = 0;
        }
        $ths = substr($ths_value . '00', 0, 2);
        $thaiNum = array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
        $unitBaht = array('บาท', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
        $unitSatang = array('สตางค์', 'สิบ');
        $THB = '';
        $j = 0;
        for ($i = strlen($thb) - 1; $i >= 0; $i--, $j++) {
            $num = $thb[$i];
            $tnum = $thaiNum[$num];
            $unit = $unitBaht[$j];
            switch (true) {
                case $j == 0 && $num == 1 && strlen($thb) > 1:
                    $tnum = 'เอ็ด';
                    break;
                case $j == 1 && $num == 1:
                    $tnum = '';
                    break;
                case $j == 1 && $num == 2:
                    $tnum = 'ยี่';
                    break;
                case $j == 6 && $num == 1 && strlen($thb) > 7:
                    $tnum = 'เอ็ด';
                    break;
                case $j == 7 && $num == 1:
                    $tnum = '';
                    break;
                case $j == 7 && $num == 2:
                    $tnum = 'ยี่';
                    break;
                case $j != 0 && $j != 6 && $num == 0:
                    $unit = '';
                    break;
            }
            $S = $tnum . $unit;
            $THB = $S . $THB;
        }
        if ($ths == '00') {
            $THS = 'ถ้วน';
        } else {
            $j = 0;
            $THS = '';
            for ($i = strlen($ths) - 1; $i >= 0; $i--, $j++) {
                $num = $ths[$i];
                $tnum = $thaiNum[$num];
                $unit = $unitSatang[$j];
                switch (true) {
                    case $j == 0 && $num == 1 && strlen($ths) > 1:
                        $tnum = 'เอ็ด';
                        break;
                    case $j == 1 && $num == 1:
                        $tnum = '';
                        break;
                    case $j == 1 && $num == 2:
                        $tnum = 'ยี่';
                        break;
                    case $j != 0 && $j != 6 && $num == 0:
                        $unit = '';
                        break;
                }
                $S = $tnum . $unit;
                $THS = $S . $THS;
            }
        }
        return $THB . $THS;
    }
}