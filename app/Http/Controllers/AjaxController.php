<?php

namespace App\Http\Controllers;

use App\Models\Amphure;
use App\Models\Destination;
use App\Models\District;

class AjaxController extends Controller
{
    private $destination;
    private $amphure;
    private $district;

    public function __construct()
    {
        $this->destination = new Destination();
        $this->amphure = new Amphure();
        $this->district = new District();
    }

    public function getDestination($id = null)
    {
        $destination = $this->destination->where('rou_id', $id)->orderBy('con_name', 'asc')->get();

        return response()->json($destination);
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