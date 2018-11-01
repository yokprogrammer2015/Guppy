<?php

namespace App\Http\Controllers;

use App\Models\Destination;

class AjaxController extends Controller
{
    private $destination;

    public function __construct()
    {
        $this->destination = new Destination();
    }

    public function getDestination($id = null)
    {
        $destination = $this->destination->where('rou_id', $id)->orderBy('con_name', 'asc')->get();

        return response()->json($destination);
    }
}