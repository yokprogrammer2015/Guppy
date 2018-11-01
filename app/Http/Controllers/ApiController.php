<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Destination;
use App\Models\Route;
use App\Models\Time;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $agent;
    private $branch;
    private $route;
    private $destination;
    private $time;
    private $bank;
    protected $setData;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->branch = new Branch();
        $this->route = new Route();
        $this->destination = new Destination();
        $this->time = new Time();
        $this->bank = new Bank();
        $this->setData = [];
    }

    public function Agent(Request $request)
    {
        $id = $request->input('id');

        $data = $this->agent->where('ag_status', 0);
        if ($id) {
            $data->where('ag_id', $id);
        }
        $agent = $data->orderBy('ag_name', 'asc')->get();

        foreach ($agent as $k => $row) {
            $this->setData['data'][$k] = [
                'agentId' => $row->ag_id,
                'branchId' => $row->branch_id,
                'name' => $row->ag_name,
                'email' => $row->ag_email,
                'address' => $row->ag_address,
                'phone' => $row->ag_phone,
                'mobile' => $row->ag_mobile,
                'fax' => $row->ag_fax
            ];
        }

        return response()->json($this->setData);
    }

    public function Branch(Request $request)
    {
        $id = $request->input('id');

        $data = $this->branch;
        if ($id) {
            $data->where('con_id', $id);
        }
        $branch = $data->orderBy('con_name', 'asc')->get();

        foreach ($branch as $k => $row) {
            $this->setData['data'][$k] = [
                'branchId' => $row->con_id,
                'routeId' => $row->rou_id,
                'name' => $row->con_name,
                'phone' => $row->phone,
                'mobile' => $row->mobile,
                'fax' => $row->fax
            ];
        }

        return response()->json($this->setData);
    }

    public function Route(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $code = $request->input('code');

        $data = $this->route;
        if ($id) {
            $data->where('con_id', $id);
        }
        if ($name) {
            $data->where('con_name', 'like', '%' . $name . '%');
        }
        if ($code) {
            $data->where('con_code', $code);
        }
        $routes = $data->orderBy('con_name', 'asc')->get();

        foreach ($routes as $k => $route) {
            $this->setData['data'][$k] = [
                'routeId' => $route->con_id,
                'routeName' => $route->con_name,
                'routeCode' => $route->con_code
            ];

            foreach ($route->destination as $j => $destination) {
                $this->setData['data'][$k]['destination'][$j] = [
                    'destinationId' => $destination->con_id,
                    'destinationName' => $destination->con_name
                ];
            }
        }

        return response()->json($this->setData);
    }

    public function Time()
    {
        $time = $this->time->orderBy('con_name', 'asc')->get();

        foreach ($time as $k => $row) {
            $this->setData['data'][$k] = [
                'timeId' => $row->con_id,
                'name' => $row->con_name
            ];
        }

        return response()->json($this->setData);
    }

    public function bank()
    {
        $bank = $this->bank->orderBy('con_name', 'asc')->get();

        foreach ($bank as $k => $row) {
            $this->setData['data'][$k] = [
                'bankId' => $row->con_id,
                'name' => $row->con_name
            ];
        }

        return response()->json($this->setData);
    }
}