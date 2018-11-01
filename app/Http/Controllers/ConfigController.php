<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Models\Bank;
use App\Models\BestSeller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Destination;
use App\Models\GetModel;
use App\Models\Route;
use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    private $model;
    private $route;
    private $bestSeller;

    public function __construct()
    {
        $this->model = new GetModel();
        $this->route = new Route();
        $this->bestSeller = new BestSeller();
    }

    public function branch()
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Branch';

        $data['branch'] = Branch::orderBy('con_name', 'asc')->get();

        return view('config.branch.list', $data);
    }

    public function addBranch($con_id = 0)
    {
        $data = array('title' => 'Add Branch', 'description' => 'Branch', 'con_id' => $con_id, 'con_name' => '',
            'rou_id' => '', 'phone' => '', 'mobile' => '', 'fax' => ''
        );
        $data['route'] = $this->route->orderBy('con_name', 'asc')->get();

        if ($con_id != 0) {
            $row = Branch::where('con_id', $con_id)->first();
            $data['con_name'] = $row->con_name;
            $data['rou_id'] = $row->rou_id;
            $data['phone'] = $row->phone;
            $data['mobile'] = $row->mobile;
            $data['fax'] = $row->fax;
        }

        return view('config.branch.add', $data);
    }

    public function route()
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Route';

        $data['route'] = Route::orderBy('con_name', 'asc')->get();

        return view('config.route.list', $data);
    }

    public function addRoute($con_id = 0)
    {
        $data['title'] = 'Add Route';
        $data['description'] = 'Route';
        $data['con_id'] = $con_id;
        $data['con_name'] = '';
        $data['con_code'] = '';

        if ($con_id != 0) {
            $row = Route::where('con_id', $con_id)->first();
            $data['con_name'] = $row->con_name;
            $data['con_code'] = $row->con_code;
        }

        return view('config.route.add', $data);
    }

    public function destination()
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Destination';

        $data['destination'] = Destination::orderBy('con_name', 'asc')->get();

        return view('config.destination.list', $data);
    }

    public function addDestination($con_id = 0)
    {
        $data = array('title' => 'Add Pickup', 'description' => 'Destination', 'con_id' => $con_id, 'con_name' => '', 'rou_id' => '');

        $data['route'] = Route::orderBy('con_name', 'asc')->get();

        if ($con_id != 0) {
            $row = Destination::where('con_id', $con_id)->first();
            $data['rou_id'] = $row->route->con_id;
            $data['con_name'] = $row->con_name;
        }

        return view('config.destination.add', $data);
    }

    public function time()
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Time';

        $data['time'] = Time::orderBy('con_name', 'asc')->get();

        return view('config.time.list', $data);
    }

    public function addTime($con_id = 0)
    {
        $data['title'] = 'Add Time';
        $data['description'] = 'Time';
        $data['con_id'] = $con_id;
        $data['con_name'] = '';

        if ($con_id != 0) {
            $row = Time::where('con_id', $con_id)->first();
            $data['con_name'] = $row->con_name;
        }

        return view('config.time.add', $data);
    }

    public function bestSeller()
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Best Seller';

        $data['bestSeller'] = BestSeller::orderBy('con_id', 'asc')->get();

        return view('config.bestSeller.list', $data);
    }

    public function addBestSeller($con_id = 0)
    {
        $data = ['con_id' => $con_id, 'cat_id' => '', 'dep_id' => 0, 'arr_id' => 0, 'time_id' => 0, 'time_to_id' => 0];
        $data['title'] = 'Add Best Seller';
        $data['description'] = 'Best Seller';

        $data['category'] = Category::orderBy('con_name', 'asc')->get();
        $data['route'] = Route::orderBy('con_name', 'asc')->get();
        $data['time'] = Time::orderBy('con_name', 'asc')->get();

        if ($con_id != 0) {
            $row = BestSeller::where('con_id', $con_id)->first();
            $data['cat_id'] = $row->cat_id;
            $data['dep_id'] = $row->dep_id;
            $data['arr_id'] = $row->arr_id;
            $data['time_id'] = $row->time_id;
            $data['time_to_id'] = $row->time_to_id;
        }

        return view('config.bestSeller.add', $data);
    }

    public function bank()
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Bank';

        $data['bank'] = Bank::orderBy('con_name', 'asc')->get();

        return view('config.bank.list', $data);
    }

    public function addBank($con_id = 0)
    {
        $data = array('title' => 'Add Bank', 'description' => 'Bank', 'con_id' => $con_id, 'con_name' => '', 'con_code' => '');

        if ($con_id != 0) {
            $row = Bank::where('con_id', $con_id)->first();
            $data['con_name'] = $row->con_name;
            $data['con_code'] = $row->con_code;
        }

        return view('config.bank.add', $data);
    }

    public function save(ConfigRequest $request)
    {
        $cat_id = $request->cat_id;
        $con_id = $request->input('con_id');
        $con_name = $request->con_name;
        $rou_id = $request->input('rou_id');
        $con_code = $request->input('con_code');
        $dep_id = $request->input('dep_id');
        $arr_id = $request->input('arr_id');
        $time_id = $request->input('time_id');
        $time_to_id = $request->input('time_to_id');
        if ($request->input('phone')) $phone = $request->input('phone'); else $phone = '';
        if ($request->input('mobile')) $mobile = $request->input('mobile'); else $mobile = '';
        if ($request->input('fax')) $fax = $request->input('fax'); else $fax = '';

        try {
            $db = $this->model->findBy($cat_id);
            if ($con_id == 0) { // Insert
                if ($con_code) $db->con_code = $con_code; // bank
                if ($rou_id) $db->rou_id = $rou_id;
                if ($phone) {
                    $db->phone = $phone;
                    $db->mobile = $mobile;
                    $db->fax = $fax;
                }
                if ($dep_id) {
                    $db->dep_id = $dep_id;
                    $db->arr_id = $arr_id;
                    $db->time_id = $time_id;
                    $db->time_to_id = $time_to_id;
                }
                $db->con_name = $con_name;
                $db->save();
            } else { // Update
                $db->where('con_id', $con_id)->update(['con_name' => $con_name]);
                if ($con_code) $db->where('con_id', $con_id)->update(['con_code' => $con_code]); // bank
                if ($rou_id) $db->where('con_id', $con_id)->update(['rou_id' => $rou_id]);
                if ($phone) {
                    $db->where('con_id', $con_id)->update([
                        'phone' => $phone,
                        'mobile' => $mobile,
                        'fax' => $fax
                    ]);
                }
                if ($dep_id) {
                    $db->where('con_id', $con_id)->update([
                        'dep_id' => $dep_id,
                        'arr_id' => $arr_id,
                        'time_id' => $time_id,
                        'time_to_id' => $time_to_id
                    ]);
                }
            }
            Log::info('Config Save : ' . serialize($request->all()));
            return redirect('config/' . $cat_id)->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Config Save : ', $exception);
            return $exception->getMessage();
        }
    }

    public function saveBestSeller(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $con_id = $request->input('con_id');
        $dep_id = $request->input('dep_id');
        $arr_id = $request->input('arr_id');
        $time_id = $request->input('time_id');
        $time_to_id = $request->input('time_to_id');

        try {
            $bestSeller = $this->bestSeller;
            if ($con_id == 0) { // Insert
                $bestSeller->cat_id = $cat_id;
                $bestSeller->dep_id = $dep_id;
                $bestSeller->arr_id = $arr_id;
                $bestSeller->time_id = $time_id;
                $bestSeller->time_to_id = $time_to_id;
                $bestSeller->save();
            } else { // Update
                $bestSeller->where('con_id', $con_id)->update([
                    'cat_id' => $cat_id,
                    'dep_id' => $dep_id,
                    'arr_id' => $arr_id,
                    'time_id' => $time_id,
                    'time_to_id' => $time_to_id
                ]);
            }
            Log::info('Config Save : ' . serialize($request->all()));
            return redirect('config/bestSeller')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Config Save : ', $exception);
            return $exception->getMessage();
        }
    }

    public function remove($cat_id = null, $con_id = null)
    {
        try {
            if ($cat_id && $con_id) {
                $db = $this->model->findBy($cat_id);

                $db->where('con_id', $con_id)->delete();
            }
            Log::info('Config Remove : By | ' . session('member_name') . ' | CatID | ' . $cat_id . ' | ID | ' . $con_id);
            return redirect('config/' . $cat_id)->with('message', 'Remove Successful!');
        } catch (\Exception $exception) {
            Log::error('Config Remove : ', $exception);
            return $exception->getMessage();
        }
    }
}