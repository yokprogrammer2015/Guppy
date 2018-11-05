<?php

namespace App\Http\Controllers;

use \Eventviva\ImageResize;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $data['order'] = $this->order->orderBy('id', 'desc')->get();

        return view('order.list', $data);
    }

    public function guppy()
    {
        $data = array('id' => '', 'expiredDate' => date('m/d/Y'));
        $data['title'] = 'Add Guppy';

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
            $this->image1->resize(100, 80);
            $this->image1->save(env("THUMBNAIL_PATH") . $running . '1.jpg');
            $this->image1->resize(600, 400);
            $this->image1->save(env("IMAGE_PATH") . $running . '1.jpg');
            $this->image1 = $running . '1.jpg';
        }
        if (!empty($pic2)) {
            $this->image2 = new ImageResize($pic2);
            $this->image2->resize(100, 80);
            $this->image2->save(env("THUMBNAIL_PATH") . $running . '2.jpg');
            $this->image2->resize(600, 400);
            $this->image2->save(env("IMAGE_PATH") . $running . '2.jpg');
            $this->image2 = $running . '2.jpg';
        }
        if (!empty($pic3)) {
            $this->image3 = new ImageResize($pic3);
            $this->image3->resize(100, 80);
            $this->image3->save(env("THUMBNAIL_PATH") . $running . '3.jpg');
            $this->image3->resize(600, 400);
            $this->image3->save(env("IMAGE_PATH") . $running . '3.jpg');
            $this->image3 = $running . '3.jpg';
        }

        try {
            if (!$id) { // Insert
                $this->order->insertGetId([
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
            //Log::info('Order Save : ' . serialize($request->all()));
            return redirect('order/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            //Log::info('Order Save : ', $exception);
            return $exception->getMessage();
        }
    }

    public function remove($order_id = null)
    {
        try {
            Log::info('Order Remove : By | ' . session('member_name') . ' | OrderID | ' . $order_id);
            $this->order->where('order_id', $order_id)->update([
                'status' => 1
            ]);
            return redirect('booking/list');
        } catch (\Exception $exception) {
            Log::info('Order Remove : ', $exception);
            return $exception->getMessage();
        }
    }
}