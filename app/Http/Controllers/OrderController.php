<?php

namespace App\Http\Controllers;

use App\Models\Category;
use \Eventviva\ImageResize;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $order;
    private $category;
    private $getFunction;
    protected $image1 = '';
    protected $image2 = '';
    protected $image3 = '';

    public function __construct()
    {
        $this->order = new Order();
        $this->category = new Category();
        $this->getFunction = new AllFunctionController();
    }

    public function index(Request $request)
    {
        $data['title'] = 'รายการสินค้า';
        $data['status'] = $request->input('status');
        $data['cat_id'] = $request->input('cat_id');
        $data['name'] = $request->input('name');
        $data['getFunction'] = $this->getFunction;
        $data['category'] = $this->category->whereNotIn('id', [10])->orderBy('name', 'asc')->get();

        $order = $this->order->where('mb_id', session('member_id'));
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['status']) {
            $order->where('status', $data['status']);
        }
        if ($data['name']) {
            $order->where('name', $data['name']);
        }
        $data['order'] = $order->orderBy('status', 'desc')->orderBy('id', 'desc')->get();

        return view('order.list', $data);
    }

    public function guppy($id = 0)
    {
        $data = array('id' => '', 'cat_id' => '', 'name' => '', 'qty' => 1, 'numberSet' => 1, 'type' => 1,
            'expiredDate' => date('m/d/Y'), 'price' => '', 'pic1_val' => '', 'pic2_val' => '', 'pic3_val' => '', 'remark' => '', 'vdo' => '');
        $data['title'] = 'เพิ่ม สินค้า';
        $data['category'] = $this->category->whereNotIn('id', [10])->orderBy('name', 'asc')->get();

        if ($id) {
            $order = $this->order->where('id', $id)->first();
            $data['id'] = $order->id;
            $data['cat_id'] = $order->cat_id;
            $data['name'] = $order->name;
            $data['qty'] = $order->qty;
            $data['numberSet'] = $order->numberSet;
            $data['type'] = $order->type;
            $data['expiredDate'] = $this->getFunction->showDateFormat($order->expiredDate);
            $data['price'] = $order->price;
            $data['pic1_val'] = $order->pic1;
            $data['pic2_val'] = $order->pic2;
            $data['pic3_val'] = $order->pic3;
            $data['remark'] = $order->remark;
            $data['vdo'] = $order->vdo;
        }

        return view('order.guppy', $data);
    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $cat_id = $request->input('cat_id');
        $name = $request->input('name');
        $qty = $request->input('qty');
        $numberSet = $request->input('numberSet');
        $price = $request->input('price');
        $remark = $request->input('remark');
        $vdo = $request->input('vdo');
        $pic1 = $request->file('pic1');
        $pic1_val = $request->input('pic1_val');
        $pic2 = $request->file('pic2');
        $pic1_va2 = $request->input('pic1_va2');
        $pic3 = $request->file('pic3');
        $pic1_va3 = $request->input('pic1_va3');
        $today = date('Y-m-d');
        $running = $this->order->genRunning();

        if ($request->input('type')) $type = $request->input('type'); else $type = 2;
        if ($request->input('expiredDate')) $expiredDate = $this->getFunction->convertDateFormat($request->input('expiredDate'));
        else $expiredDate = $today;

        if ($pic1_val) {
            $this->image1 = $pic1_val;
        }
        if ($pic1_va2) {
            $this->image2 = $pic1_va2;
        }
        if ($pic1_va3) {
            $this->image3 = $pic1_va3;
        }

        if (!empty($pic1)) {
            $this->image1 = new ImageResize($pic1);
            $this->image1->resize(150, 100);
            $this->image1->save(env("THUMBNAIL_PATH") . $running . '1.jpg');
            $this->image1->resize(600, 400);
            $this->image1->save(env("IMAGE_PATH") . $running . '1.jpg');
            $this->image1 = $running . '1.jpg';
        }
        if (!empty($pic2)) {
            $this->image2 = new ImageResize($pic2);
            $this->image2->resize(150, 100);
            $this->image2->save(env("THUMBNAIL_PATH") . $running . '2.jpg');
            $this->image2->resize(600, 400);
            $this->image2->save(env("IMAGE_PATH") . $running . '2.jpg');
            $this->image2 = $running . '2.jpg';
        }
        if (!empty($pic3)) {
            $this->image3 = new ImageResize($pic3);
            $this->image3->resize(150, 100);
            $this->image3->save(env("THUMBNAIL_PATH") . $running . '3.jpg');
            $this->image3->resize(600, 400);
            $this->image3->save(env("IMAGE_PATH") . $running . '3.jpg');
            $this->image3 = $running . '3.jpg';
        }

        try {
            if (!$id) { // Insert
                $this->order->insertGetId([
                    'cat_id' => $cat_id,
                    'mb_id' => session('member_id'),
                    'name' => $name,
                    'qty' => $qty,
                    'numberSet' => $numberSet,
                    'type' => $type,
                    'expiredDate' => $expiredDate,
                    'price' => $price,
                    'remark' => $remark,
                    'vdo' => $vdo,
                    'status' => 'Y',
                    'pic1' => $this->image1,
                    'pic2' => $this->image2,
                    'pic3' => $this->image3,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);
            } else { // Update
                $this->order->where('id', $id)->update([
                    'cat_id' => $cat_id,
                    'mb_id' => session('member_id'),
                    'name' => $name,
                    'qty' => $qty,
                    'numberSet' => $numberSet,
                    'type' => $type,
                    'expiredDate' => $expiredDate,
                    'price' => $price,
                    'remark' => $remark,
                    'vdo' => $vdo,
                    'status' => 'Y',
                    'pic1' => $this->image1,
                    'pic2' => $this->image2,
                    'pic3' => $this->image3,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);
            }
            return redirect('order/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function remove($id = null)
    {
        try {
            $this->order->where('mb_id', session('member_id'))->where('id', $id)->update([
                'status' => 'N'
            ]);
            return redirect('order/list');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}