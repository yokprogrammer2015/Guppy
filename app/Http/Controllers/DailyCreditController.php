<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use App\Models\ClearCredit;
use App\Models\DailySale;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyCreditController extends Controller
{
    private $order;
    private $dailySale;
    private $agent;
    private $category;
    private $clearCredit;
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
        $this->clearCredit = new ClearCredit();
        $this->getFunction = new AllFunctionController();
        $this->dataOrder = [];
        $this->dataNotOrder = [];
        $dailySale = $this->dailySale->where('type_id', 2)->select('order_id')->get();

        foreach ($dailySale as $row) {
            $this->dataOrder[] = $row->order_id;
        }

        $dailySale2 = $this->dailySale->where('type_id', 2)->orWhere('type_id', 1)->select('order_id')->get();
        foreach ($dailySale2 as $row) {
            $this->dataNotOrder[] = $row->order_id;
        }
    }

    public function index(Request $request)
    {
        $data['title'] = 'List Daily Sale Credit';
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['ds_book'] = $request->input('ds_book');
        $data['ds_no'] = $request->input('ds_no');
        $branch_id = session('branch_id');
        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        if ($data['ds_book']) {
            $this->dataOrder = [];
            $daily = $this->dailySale->where('branch_id', $branch_id)->where('type_id', 2)->where('ds_book', $data['ds_book'])->get();
            foreach ($daily as $row) {
                $this->dataOrder[] = $row->order_id;
            }
        }
        if ($data['ds_no']) {
            $this->dataOrder = [];
            $daily = $this->dailySale->where('branch_id', $branch_id)->where('type_id', 2)->where('ds_no', $data['ds_no'])->get();
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

        return view('dailyCredit.list', $data);
    }

    public function boat(Request $request)
    {
        $data['title'] = 'Booking Boat';
        $data['description'] = 'Boat';
        $data['titleDetail'] = 'Daily Sale Credit Boat';
        $data['travel_date'] = date('m/d/Y');
        if ($request->input('travel_date')) $travel_date = $this->getFunction->convertDateFormat($request->input('travel_date')); else $travel_date = '';
        $branch_id = session('branch_id');

        $order = $this->order->where('branch_id', $branch_id)->where('cat_id', 1)->where('status', 0)->whereNotIn('order_id', $this->dataNotOrder);
        if ($travel_date) {
            $order->where('travel_date', $travel_date);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();

        return view('dailyCredit.boat', $data);
    }

    public function jointTicket(Request $request)
    {
        $data['title'] = 'Booking Joint Ticket';
        $data['description'] = 'Joint Ticket';
        $data['titleDetail'] = 'Daily Sale Credit Joint Ticket';
        $data['travel_date'] = date('m/d/Y');
        if ($request->input('travel_date')) $travel_date = $this->getFunction->convertDateFormat($request->input('travel_date')); else $travel_date = '';
        $branch_id = session('branch_id');

        $order = $this->order->where('branch_id', $branch_id)->where('cat_id', 2)->where('status', 0)->whereNotIn('order_id', $this->dataNotOrder);
        if ($travel_date) {
            $order->where('travel_date', $travel_date);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();

        return view('dailyCredit.jointTicket', $data);
    }

    public function bus(Request $request)
    {
        $data['title'] = 'Booking Bus';
        $data['description'] = 'Bus';
        $data['titleDetail'] = 'Daily Sale Credit Bus';
        $data['travel_date'] = date('m/d/Y');
        if ($request->input('travel_date')) $travel_date = $this->getFunction->convertDateFormat($request->input('travel_date')); else $travel_date = '';
        $branch_id = session('branch_id');

        $order = $this->order->where('branch_id', $branch_id)->where('cat_id', 3)->where('status', 0)->whereNotIn('order_id', $this->dataNotOrder);
        if ($travel_date) {
            $order->where('travel_date', $travel_date);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();

        return view('dailyCredit.bus', $data);
    }

    public function train()
    {
        $data['title'] = 'Booking Train';
        $data['description'] = 'Train';
        $data['titleDetail'] = 'Daily Sale Credit Train';
        $data['travel_date'] = date('m/d/Y');

        return view('dailyCredit.train', $data);
    }

    public function report(Request $request)
    {
        $data = array('grand_sell' => 0, 'grand_net' => 0, 'grand_profit' => 0);
        $ds_book = $request->input('ds_book');
        $ds_no = $request->input('ds_no');
        $branch_id = session('branch_id');
        $type_id = $request->input('type_id');
        $cat_id = $request->input('cat_id');
        $ag_id = $request->input('ag_id');
        $data['type_name'] = $request->input('type_name');
        $data['ds_book'] = str_pad($ds_book, 4, "0", STR_PAD_LEFT);
        $data['ds_no'] = str_pad($ds_no, 6, "0", STR_PAD_LEFT);
        $data['getFunction'] = $this->getFunction;

        if ($ds_book) {
            $this->dataOrder = [];
            $daily = $this->dailySale->where('branch_id', $branch_id)->where('type_id', $type_id)->where('ds_book', $ds_book)->get();
            foreach ($daily as $row) {
                $this->dataOrder[] = $row->order_id;
                session()->put('cat_id', $row->cat_id);
            }
        }
        if ($ds_no) {
            $this->dataOrder = [];
            $daily = $this->dailySale->where('branch_id', $branch_id)->where('type_id', $type_id)->where('ds_no', $ds_no)->get();
            foreach ($daily as $row) {
                $this->dataOrder[] = $row->order_id;
                session()->put('cat_id', $row->cat_id);
            }
        }

        $data['category'] = $this->category->where('con_id', session('cat_id'))->first();

        $order = $this->order->where('branch_id', $branch_id)->whereIn('order_id', $this->dataOrder);
        if ($cat_id) {
            $order->where('cat_id', $cat_id);
        }
        if ($ag_id) {
            $order->where('ag_id', $ag_id);
        }

        $data['order'] = $order->orderBy('travel_date', 'desc')->get();

        $pdf = PDF::loadView('pdf.dailySale', $data)->setPaper('a4', 'landscape')->setWarnings(false);
        return @$pdf->stream();
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
                        'type_id' => 2, // Credit
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
            Log::info('Daily Credit Save : ' . serialize($request->all()));
            return redirect('daily/credit/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Daily Credit Save : ', $exception);
            return $exception->getMessage();
        }
    }
}