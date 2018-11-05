<?php

namespace App\Http\Controllers;

use \Eventviva\ImageResize;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $order;
    private $getFunction;
    protected $image1 = '';
    protected $image2 = '';
    protected $image3 = '';

    public function __construct()
    {
        $this->order = new Order();
        $this->getFunction = new AllFunctionController();
    }

    public function index(Request $request)
    {
        $data['title'] = 'List Orders';
        $data['status'] = $request->input('status');
        $data['name'] = $request->input('name');
        $data['getFunction'] = $this->getFunction;

        $order = $this->order->where('mb_id', session('member_id'));
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
        $data = array('id' => '', 'name' => '', 'type' => 1, 'expiredDate' => date('m/d/Y'), 'price' => '',
            'pic1_val' => '', 'pic2_val' => '', 'pic3_val' => '', 'remark' => '');
        $data['title'] = 'Add Guppy';

        if ($id) {
            $order = $this->order->where('id', $id)->first();
            $data['id'] = $order->id;
            $data['name'] = $order->name;
            $data['type'] = $order->type;
            $data['expiredDate'] = $this->getFunction->showDateFormat($order->expiredDate);
            $data['price'] = $order->price;
            $data['pic1_val'] = $order->pic1;
            $data['pic2_val'] = $order->pic2;
            $data['pic3_val'] = $order->pic3;
            $data['remark'] = $order->remark;
        }

        return view('order.guppy', $data);
    }

    public function save(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $type = $request->input('type');
        $price = $request->input('price');
        $remark = $request->input('remark');
        $pic1 = $request->file('pic1');
        $pic2 = $request->file('pic2');
        $pic3 = $request->file('pic3');
        $running = $this->order->genRunning();

        if ($request->input('expiredDate')) $expiredDate = $this->getFunction->convertDateFormat($request->input('expiredDate'));
        else $expiredDate = $request->input('expiredDate');

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
                    'mb_id' => session('member_id'),
                    'name' => $name,
                    'type' => $type,
                    'expiredDate' => $expiredDate,
                    'price' => $price,
                    'remark' => $remark,
                    'status' => 'Y',
                    'pic1' => $this->image1,
                    'pic2' => $this->image2,
                    'pic3' => $this->image3,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);
            } else { // Update
                $this->order->where('id', $id)->update([
                    'mb_id' => session('member_id'),
                    'name' => $name,
                    'type' => $type,
                    'expiredDate' => $expiredDate,
                    'price' => $price,
                    'remark' => $remark,
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