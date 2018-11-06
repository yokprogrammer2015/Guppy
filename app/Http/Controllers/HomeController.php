<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $data['cat_id'] = $request->input('cat_id');
        $data['name'] = $request->input('name');
        $data['category'] = $this->category->whereNotIn('id', [10])->orderBy('name', 'asc')->get();

        $order = $this->order->where('status', 'Y');
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['name']) {
            $order->where('name', $data['name']);
        }
        $data['order'] = $order->orderBy('status', 'desc')->orderBy('id', 'desc')->get();

        return view('home.index', $data);
    }
}