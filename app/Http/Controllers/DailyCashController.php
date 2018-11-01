<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use App\Models\DailySale;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyCashController extends Controller
{
    private $order;
    private $dailySale;
    private $agent;
    private $category;
    protected $getFunction;
    protected $dataSet;
    protected $dataOrder;
    protected $dataNotOrder;

    public function __construct()
    {
        $this->order = new Order();
        $this->dailySale = new DailySale();
        $this->agent = new Agent();
        $this->category = new Category();
        $this->getFunction = new AllFunctionController();
        $this->dataOrder = [];
        $this->dataNotOrder = [];
        $dailySale = $this->dailySale->where('type_id', 1)->select('order_id')->get();

        foreach ($dailySale as $row) {
            $this->dataOrder[] = $row->order_id;
        }

        $dailySale2 = $this->dailySale->where('type_id', 1)->orWhere('type_id', 2)->select('order_id')->get();
        foreach ($dailySale2 as $row) {
            $this->dataNotOrder[] = $row->order_id;
        }
    }

    public function index(Request $request)
    {
        $data['title'] = 'List Daily Sale Cash';
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['ds_book'] = $request->input('ds_book');
        $data['ds_no'] = $request->input('ds_no');
        $branch_id = session('branch_id');
        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        if ($data['ds_book']) {
            $this->dataOrder = [];
            $daily = $this->dailySale->where('branch_id', $branch_id)->where('type_id', 1)->where('ds_book', $data['ds_book'])->get();
            foreach ($daily as $row) {
                $this->dataOrder[] = $row->order_id;
            }
        }
        if ($data['ds_no']) {
            $this->dataOrder = [];
            $daily = $this->dailySale->where('branch_id', $branch_id)->where('type_id', 1)->where('ds_no', $data['ds_no'])->get();
            foreach ($daily as $row) {
                $this->dataOrder[] = $row->order_id;
            }
        }

        $order = $this->order->where('branch_id', $branch_id)->whereIn('order_id', $this->dataOrder);
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['ag_id']) {
            $order->where('ag_id', $data['ag_id']);
        }

        $data['order'] = $order->orderBy('travel_date', 'desc')->get();

        return view('dailyCash.list', $data);
    }

    public function boat(Request $request)
    {
        $data['title'] = 'Booking Boat';
        $data['description'] = 'Boat';
        $data['titleDetail'] = 'Daily Sale Cash Boat';
        $data['travel_date'] = date('m/d/Y');
        if ($request->input('travel_date')) $travel_date = $this->getFunction->convertDateFormat($request->input('travel_date')); else $travel_date = '';
        $branch_id = session('branch_id');

        $order = $this->order->where('branch_id', $branch_id)->where('cat_id', 1)->where('status', 0)->whereNotIn('order_id', $this->dataNotOrder);
        if ($travel_date) {
            $order->where('travel_date', $travel_date);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();

        return view('dailyCash.boat', $data);
    }

    public function jointTicket(Request $request)
    {
        $data['title'] = 'Booking Joint Ticket';
        $data['description'] = 'Joint Ticket';
        $data['titleDetail'] = 'Daily Sale Cash Joint Ticket';
        $data['travel_date'] = date('m/d/Y');
        if ($request->input('travel_date')) $travel_date = $this->getFunction->convertDateFormat($request->input('travel_date')); else $travel_date = '';
        $branch_id = session('branch_id');

        $order = $this->order->where('branch_id', $branch_id)->where('cat_id', 2)->where('status', 0)->whereNotIn('order_id', $this->dataNotOrder);
        if ($travel_date) {
            $order->where('travel_date', $travel_date);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();

        return view('dailyCash.jointTicket', $data);
    }

    public function bus(Request $request)
    {
        $data['title'] = 'Booking Bus';
        $data['description'] = 'Bus';
        $data['titleDetail'] = 'Daily Sale Cash Bus';
        $data['travel_date'] = date('m/d/Y');
        if ($request->input('travel_date')) $travel_date = $this->getFunction->convertDateFormat($request->input('travel_date')); else $travel_date = '';
        $branch_id = session('branch_id');
        $order = $this->order->where('branch_id', $branch_id)->where('cat_id', 3)->where('status', 0)->whereNotIn('order_id', $this->dataNotOrder);
        if ($travel_date) {
            $order->where('travel_date', $travel_date);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();

        return view('dailyCash.bus', $data);
    }

    public function train()
    {
        $data['title'] = 'Booking Train';
        $data['description'] = 'Train';
        $data['titleDetail'] = 'Daily Sale Cash Train';
        $data['travel_date'] = date('m/d/Y');

        return view('dailyCash.train', $data);
    }

    public function save(Request $request)
    {
        $order_id = $request->input('order_id');
        $cat_id = $request->input('cat_id');
        $mb_id = session('member_id');
        $branch_id = session('branch_id');
        $net_adult = $request->input('net_adult');
        $net_child = $request->input('net_child');
        $price_adult = $request->input('price_adult');
        $price_child = $request->input('price_child');
        $ticket_no = $request->input('ticket_no');

        try {
            if ($order_id) {
                $running = $this->getFunction->getRunning(session('branch_id'), $cat_id);

                foreach ($order_id as $k => $row) {
                    $this->dataSet[] = [
                        'mb_id' => $mb_id,
                        'branch_id' => $branch_id,
                        'cat_id' => $cat_id,
                        'order_id' => $row,
                        'type_id' => 1, // Cash
                        'clear_id' => 0,
                        'ds_book' => $running['ds_book'],
                        'ds_no' => $running['ds_no'],
                        'creation_date' => now(),
                        'last_update' => now()
                    ];

                    DB::table('order')->where('order_id', $row)->update([
                        'net_adult' => $net_adult[$k],
                        'net_child' => $net_child[$k],
                        'price_adult' => $price_adult[$k],
                        'price_child' => $price_child[$k],
                        'ticket_no' => $ticket_no[$k]
                    ]);
                }

                DB::table('daily_sale')->insert($this->dataSet);
            }
            Log::info('Daily Cash Save : ' . serialize($request->all()));
            return redirect('daily/cash/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Daily Cash Save : ', $exception);
            return $exception->getMessage();
        }
    }
}