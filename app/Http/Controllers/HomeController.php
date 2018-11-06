<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $data['title'] = 'รายการสินค้า';
        $data['name'] = $request->input('name');

        $order = $this->order->where('status', 'Y');
        if ($data['name']) {
            $order->where('name', $data['name']);
        }
        $data['order'] = $order->orderBy('status', 'desc')->orderBy('id', 'desc')->get();

        return view('home.index', $data);
    }
}