<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Category;
use App\Models\GetModel;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new GetModel();
    }

    public function category()
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Category';

        $data['category'] = Category::orderBy('name', 'asc')->get();

        return view('config.category.list', $data);
    }

    public function addCategory($con_id = 0)
    {
        $data = array('title' => 'Add Category', 'description' => 'Category', 'con_id' => $con_id, 'name' => '', 'name_th' => '');

        if ($con_id != 0) {
            $row = Category::where('id', $con_id)->first();
            $data['name'] = $row->name;
            $data['name_th'] = $row->name_th;
        }

        return view('config.category.add', $data);
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

    public function save(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $con_id = $request->input('con_id');
        $con_name = $request->input('con_name');
        $con_code = $request->input('con_code');
        $name = $request->input('name');
        $name_th = $request->input('name_th');

        try {
            $db = $this->model->findBy($cat_id);
            if ($con_id == 0) { // Insert
                if ($con_name) $db->con_name = $con_name; // bank
                if ($con_code) $db->con_code = $con_code; // bank
                if ($name) $db->name = $name; // category
                if ($name_th) $db->name_th = $name_th; // category
                $db->save();
            } else { // Update
                if ($con_name) $db->where('con_id', $con_id)->update(['con_name' => $con_name]); // bank
                if ($con_code) $db->where('con_id', $con_id)->update(['con_code' => $con_code]); // bank
                if ($name) $db->where('id', $con_id)->update(['name' => $name]); // category
                if ($name_th) $db->where('id', $con_id)->update(['name_th' => $name_th]); // category
            }
            return redirect('config/' . $cat_id)->with('message', 'Successful!');
        } catch (\Exception $exception) {
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
            return redirect('config/' . $cat_id)->with('message', 'Remove Successful!');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}