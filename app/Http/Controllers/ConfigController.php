<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Models\Bank;
use App\Models\GetModel;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new GetModel();
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