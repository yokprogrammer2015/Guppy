<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Category;
use App\Models\GetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    private $model;
    private $category;
    private $bank;

    public function __construct()
    {
        $this->model = new GetModel();
        $this->category = new Category();
        $this->bank = new Bank();
    }

    public function category(Request $request)
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Category';
        $data['name'] = $request->input('name');

        $category = $this->category->where('id', '<>', '');
        if ($data['name']) {
            $category->where('name', $data['name']);
        }
        $data['category'] = $category->orderBy('name', 'asc')->get();

        return view('config.category.list', $data);
    }

    public function addCategory($id = 0)
    {
        $data = array('title' => 'Add Category', 'description' => 'Category', 'id' => $id, 'name' => '', 'name_th' => '');

        if ($id != 0) {
            $row = Category::where('id', $id)->first();
            $data['name'] = $row->name;
            $data['name_th'] = $row->name_th;
        }

        return view('config.category.add', $data);
    }

    public function bank(Request $request)
    {
        $data['title'] = 'Config :';
        $data['description'] = 'Bank';
        $data['name'] = $request->input('name');

        $bank = $this->bank->where('name', '<>', '');
        if ($data['name']) {
            $bank->where('name', $data['name']);
        }
        $data['bank'] = $bank->orderBy('name', 'asc')->get();

        return view('config.bank.list', $data);
    }

    public function addBank($id = 0)
    {
        $data = array('title' => 'Add Bank', 'description' => 'Bank', 'id' => $id, 'name' => '', 'code' => '');

        if ($id != 0) {
            $row = Bank::where('id', $id)->first();
            $data['name'] = $row->name;
            $data['code'] = $row->code;
        }

        return view('config.bank.add', $data);
    }

    public function save(Request $request)
    {
        try {
            $cat_id = $request->input('cat_id');
            $id = $request->input('id');
            $name = $request->input('name');
            $code = $request->input('code');
            $name_th = $request->input('name_th');

            $db = $this->model->findBy($cat_id);
            if ($id == 0) { // Insert
                if ($code) $db->code = $code; // bank
                if ($name) $db->name = $name; // category
                if ($name_th) $db->name_th = $name_th; // category
                $db->save();
            } else { // Update
                if ($name) $db->where('id', $id)->update(['name' => $name]); // bank
                if ($code) $db->where('id', $id)->update(['code' => $code]); // bank
                if ($name) $db->where('id', $id)->update(['name' => $name]); // category
                if ($name_th) $db->where('id', $id)->update(['name_th' => $name_th]); // category
            }

            Log::info('Config Save : ' . serialize($request->all()));
            return redirect('config/' . $cat_id)->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::info('Config Save : ', $exception->getTrace());
            return $exception->getMessage();
        }
    }

    public function remove($cat_id = null, $id = null)
    {
        try {
            if ($cat_id && $id) {
                $db = $this->model->findBy($cat_id);

                $db->where('id', $id)->delete();
            }

            Log::info('Config Remove : CatID | ' . $cat_id . ' | ID | ' . $id);
            return redirect('config/' . $cat_id)->with('message', 'Remove Successful!');
        } catch (\Exception $exception) {
            Log::info('Config Remove : ', $exception->getTrace());
            return $exception->getMessage();
        }
    }
}