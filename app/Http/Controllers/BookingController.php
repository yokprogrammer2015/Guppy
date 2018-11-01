<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Agent;
use App\Models\Category;
use App\Models\DailySale;
use App\Models\Destination;
use App\Models\Order;
use App\Models\Route;
use App\Models\Time;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $order;
    private $route;
    private $time;
    private $destination;
    private $agent;
    private $category;
    private $dailySale;
    protected $getFunction;
    protected $dataOrder;
    protected $comCode;

    public function __construct()
    {
        $this->order = new Order();
        $this->route = new Route();
        $this->time = new Time();
        $this->destination = new Destination();
        $this->agent = new Agent();
        $this->category = new Category();
        $this->getFunction = new AllFunctionController();
        $this->dailySale = new DailySale();
        $this->dataOrder = [];
        $this->comCode = $this->getFunction->genComCode();

        $dailySale = $this->dailySale->select('order_id')->get();
        foreach ($dailySale as $row) {
            $this->dataOrder[] = $row->order_id;
        }
    }

    public function index(Request $request)
    {
        $data['title'] = 'List Booking';
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['ticket_no'] = $request->input('ticket_no');
        $branch_id = session('branch_id');
        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        $order = $this->order->whereNotIn('order_id', $this->dataOrder);
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['ag_id']) {
            $order->where('ag_id', $data['ag_id']);
        }
        if ($data['ticket_no']) {
            $order->where('ticket_no', $data['ticket_no']);
        }
        $data['order'] = $order->where('branch_id', $branch_id)->where('status', 0)->orderBy('order_id', 'desc')->get();

        return view('booking.list', $data);
    }

    public function boat(Request $request, $id = null)
    {
        $data = array('title' => 'Booking Boat', 'description' => 'Boat', 'id' => $id, 'order_id' => '', 'com_code' => $this->comCode, 'ticket_no' => '', 'dep_id' => $request->input('dep_id'),
            'time_id' => $request->input('time_id'), 'pick_id' => '', 'arr_id' => $request->input('arr_id'), 'time_to_id' => $request->input('time_to_id'), 'drop_id' => '', 'travel_type' => '',
            'bus' => '', 'adult' => $request->input('adult'), 'child' => 0, 'ag_id' => '', 'voucher_no' => '', 'name' => '', 'email' => '',
            'net_adult' => '', 'net_child' => '', 'price_adult' => '', 'price_child' => '', 'remark' => ''
        );
        if ($request->input('travel_date')) $data['travel_date'] = $request->input('travel_date'); else $data['travel_date'] = date('m/d/Y');

        $data['route'] = $this->route->orderBy('con_name', 'asc')->get();
        $data['time'] = $this->time->orderBy('con_name', 'asc')->get();
        $branch_id = session('branch_id');
        $destination = $this->destination->where('con_id', '<>', '');
        if (session('route_id')) {
            $destination->where('rou_id', session('route_id'));
        }
        $data['destination'] = $destination->where('rou_id', session('route_id'))->orderBy('con_name', 'asc')->get();
        $data['agent'] = $this->agent->where('branch_id', $branch_id)->orderBy('ag_name', 'asc')->get();

        if ($id) {
            $row = $this->order->where('order_id', $id)->first();
            if (count($row) > 0) {
                $data['order_id'] = $row->order_id;
                $data['com_code'] = $row->com_code;
                $data['ticket_no'] = $row->ticket_no;
                $data['dep_id'] = $row->dep_id;
                $data['time_id'] = $row->time_id;
                $data['pick_id'] = $row->pick_id;
                $data['arr_id'] = $row->arr_id;
                $data['time_to_id'] = $row->time_to_id;
                $data['drop_id'] = $row->drop_id;
                $data['travel_type'] = $row->travel_type;
                $data['travel_date'] = $this->getFunction->showDateFormat($row->travel_date);
                $data['bus'] = $row->bus;
                $data['adult'] = $row->adult;
                $data['child'] = $row->child;
                $data['ag_id'] = $row->ag_id;
                $data['voucher_no'] = $row->voucher_no;
                $data['name'] = $row->name;
                $data['email'] = $row->email;
                $data['net_adult'] = $row->net_adult;
                $data['net_child'] = $row->net_child;
                $data['price_adult'] = $row->price_adult;
                $data['price_child'] = $row->price_child;
                $data['remark'] = $row->remark;
            }
        }

        return view('booking.boat', $data);
    }

    public function jointTicket(Request $request, $id = null)
    {
        $data = array('title' => 'Booking Joint Ticket', 'description' => 'Joint Ticket', 'id' => $id, 'order_id' => '', 'com_code' => $this->comCode, 'ticket_no' => '', 'dep_id' => $request->input('dep_id'),
            'time_id' => $request->input('time_id'), 'pick_id' => '', 'arr_id' => $request->input('arr_id'), 'time_to_id' => $request->input('time_to_id'), 'drop_id' => '', 'travel_type' => '',
            'bus' => '', 'adult' => $request->input('adult'), 'child' => 0, 'ag_id' => '', 'voucher_no' => '', 'name' => '', 'email' => '',
            'net_adult' => '', 'net_child' => '', 'price_adult' => '', 'price_child' => '', 'remark' => ''
        );
        if ($request->input('travel_date')) $data['travel_date'] = $request->input('travel_date'); else $data['travel_date'] = date('m/d/Y');

        $data['route'] = $this->route->orderBy('con_name', 'asc')->get();
        $data['time'] = $this->time->orderBy('con_name', 'asc')->get();
        $branch_id = session('branch_id');
        $destination = $this->destination->where('con_id', '<>', '');
        if (session('route_id')) {
            $destination->where('rou_id', session('route_id'));
        }
        $data['destination'] = $destination->where('rou_id', session('route_id'))->orderBy('con_name', 'asc')->get();
        $data['agent'] = $this->agent->where('branch_id', $branch_id)->orderBy('ag_name', 'asc')->get();

        if ($id) {
            $row = $this->order->where('order_id', $id)->first();
            if (count($row) > 0) {
                $data['order_id'] = $row->order_id;
                $data['com_code'] = $row->com_code;
                $data['ticket_no'] = $row->ticket_no;
                $data['dep_id'] = $row->dep_id;
                $data['time_id'] = $row->time_id;
                $data['pick_id'] = $row->pick_id;
                $data['arr_id'] = $row->arr_id;
                $data['time_to_id'] = $row->time_to_id;
                $data['drop_id'] = $row->drop_id;
                $data['travel_type'] = $row->travel_type;
                $data['travel_date'] = $this->getFunction->showDateFormat($row->travel_date);
                $data['bus'] = $row->bus;
                $data['adult'] = $row->adult;
                $data['child'] = $row->child;
                $data['ag_id'] = $row->ag_id;
                $data['voucher_no'] = $row->voucher_no;
                $data['name'] = $row->name;
                $data['email'] = $row->email;
                $data['net_adult'] = $row->net_adult;
                $data['net_child'] = $row->net_child;
                $data['price_adult'] = $row->price_adult;
                $data['price_child'] = $row->price_child;
                $data['remark'] = $row->remark;
            }
        }

        return view('booking.jointTicket', $data);
    }

    public function bus(Request $request, $id = null)
    {
        $data = array('title' => 'Booking Bus', 'description' => 'Bus', 'id' => $id, 'order_id' => '', 'com_code' => $this->comCode, 'ticket_no' => '', 'dep_id' => $request->input('dep_id'),
            'time_id' => $request->input('time_id'), 'pick_id' => '', 'arr_id' => $request->input('arr_id'), 'time_to_id' => $request->input('time_to_id'), 'drop_id' => '', 'travel_type' => '',
            'bus' => '', 'adult' => $request->input('adult'), 'child' => 0, 'ag_id' => '', 'voucher_no' => '', 'name' => '', 'email' => '',
            'net_adult' => '', 'net_child' => '', 'price_adult' => '', 'price_child' => '', 'remark' => ''
        );
        if ($request->input('travel_date')) $data['travel_date'] = $request->input('travel_date'); else $data['travel_date'] = date('m/d/Y');

        $data['route'] = $this->route->orderBy('con_name', 'asc')->get();
        $data['time'] = $this->time->orderBy('con_name', 'asc')->get();
        $branch_id = session('branch_id');
        $destination = $this->destination->where('con_id', '<>', '');
        if (session('route_id')) {
            $destination->where('rou_id', session('route_id'));
        }
        $data['destination'] = $destination->where('rou_id', session('route_id'))->orderBy('con_name', 'asc')->get();
        $data['agent'] = $this->agent->where('branch_id', $branch_id)->orderBy('ag_name', 'asc')->get();

        if ($id) {
            $row = $this->order->where('order_id', $id)->first();
            if (count($row) > 0) {
                $data['order_id'] = $row->order_id;
                $data['com_code'] = $row->com_code;
                $data['ticket_no'] = $row->ticket_no;
                $data['dep_id'] = $row->dep_id;
                $data['time_id'] = $row->time_id;
                $data['pick_id'] = $row->pick_id;
                $data['arr_id'] = $row->arr_id;
                $data['time_to_id'] = $row->time_to_id;
                $data['drop_id'] = $row->drop_id;
                $data['travel_type'] = $row->travel_type;
                $data['travel_date'] = $this->getFunction->showDateFormat($row->travel_date);
                $data['bus'] = $row->bus;
                $data['adult'] = $row->adult;
                $data['child'] = $row->child;
                $data['ag_id'] = $row->ag_id;
                $data['voucher_no'] = $row->voucher_no;
                $data['name'] = $row->name;
                $data['email'] = $row->email;
                $data['net_adult'] = $row->net_adult;
                $data['net_child'] = $row->net_child;
                $data['price_adult'] = $row->price_adult;
                $data['price_child'] = $row->price_child;
                $data['remark'] = $row->remark;
            }
        }

        return view('booking.bus', $data);
    }

    public function save(BookingRequest $request)
    {
        $order_id = $request->input('order_id');
        $branch_id = session('branch_id');
        $com_code = $request->input('com_code');
        $ticket_no = $request->input('ticket_no');
        $time_to_id = $request->input('time_to_id');
        $drop_id = $request->input('dropOff_id');
        $pickUp_id = $request->input('pickUp_id');
        $travel_type = $request->input('travel_type');
        $child = $request->input('child');
        $bus = $request->input('bus');
        $mb_id = session('member_id');
        $ag_id = $request->input('ag_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $net_child = $request->input('net_child');
        $price_child = $request->input('price_child');
        $remark = $request->input('remark');
        if ($request->travel_date) $travel_date = $this->getFunction->convertDateFormat($request->travel_date);
        else $travel_date = $request->travel_date;

        try {
            if (!$order_id) { // Insert
                $order = $this->order->insertGetId([
                    'cat_id' => $request->cat_id,
                    'branch_id' => $branch_id,
                    'com_code' => $com_code,
                    'ticket_no' => $ticket_no,
                    'dep_id' => $request->dep_id,
                    'time_id' => $request->time_id,
                    'pick_id' => $pickUp_id,
                    'arr_id' => $request->arr_id,
                    'time_to_id' => $time_to_id,
                    'drop_id' => $drop_id,
                    'travel_type' => $travel_type,
                    'travel_date' => $travel_date,
                    'adult' => $request->adult,
                    'child' => $child,
                    'bus' => $bus,
                    'mb_id' => $mb_id,
                    'ag_id' => $ag_id,
                    'voucher_no' => $request->voucher_no,
                    'name' => "$name",
                    'email' => "$email",
                    'net_adult' => $request->net_adult,
                    'net_child' => $net_child,
                    'price_adult' => $request->price_adult,
                    'price_child' => $price_child,
                    'remark' => $remark,
                    'status' => 0,
                    'creation_date' => now(),
                    'last_update' => now()
                ]);

                $data['order'] = $this->order->where('order_id', $order)->get();
                $data['getFunction'] = $this->getFunction;

                $file = env('TICKET_PATH') . $order . '.pdf';
                PDF::loadView('pdf.ticket', $data)->save($file);
            } else { // Update
                $this->order->where('order_id', $order_id)->update([
                    'branch_id' => $branch_id,
                    'com_code' => $com_code,
                    'ticket_no' => $ticket_no,
                    'dep_id' => $request->dep_id,
                    'time_id' => $request->time_id,
                    'pick_id' => $pickUp_id,
                    'arr_id' => $request->arr_id,
                    'time_to_id' => $time_to_id,
                    'drop_id' => $drop_id,
                    'travel_type' => $travel_type,
                    'travel_date' => $travel_date,
                    'adult' => $request->adult,
                    'child' => $child,
                    'bus' => $bus,
                    'mb_id' => $mb_id,
                    'ag_id' => $ag_id,
                    'voucher_no' => $request->voucher_no,
                    'name' => "$name",
                    'email' => "$email",
                    'net_adult' => $request->net_adult,
                    'net_child' => $net_child,
                    'price_adult' => $request->price_adult,
                    'price_child' => $price_child,
                    'remark' => $remark,
                    'status' => 0
                ]);
            }
            Log::info('Booking Save : ' . serialize($request->all()));
            return redirect('booking/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Booking Save : ', $exception);
            return $exception->getMessage();
        }
    }

    public function remove($order_id = null)
    {
        try {
            Log::info('Booking Remove : By | ' . session('member_name') . ' | OrderID | ' . $order_id);
            $this->order->where('order_id', $order_id)->update([
                'status' => 1
            ]);
            return redirect('booking/list');
        } catch (\Exception $exception) {
            Log::error('Booking Remove : ', $exception);
            return $exception->getMessage();
        }
    }
}