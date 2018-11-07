<?php

namespace App\Http\Controllers;

use App\Models\Amphure;
use App\Models\District;

class AjaxController extends Controller
{
    private $amphure;
    private $district;

    public function __construct()
    {
        $this->amphure = new Amphure();
        $this->district = new District();
    }

    public function getAmphure($id = null)
    {
        $amphure = $this->amphure->where('province_id', $id)->orderBy('name_th', 'asc')->get();

        return response()->json($amphure);
    }

    public function getDistrict($id = null)
    {
        $district = $this->district->where('amphure_id', $id)->orderBy('name_th', 'asc')->get();

        return response()->json($district);
    }
}