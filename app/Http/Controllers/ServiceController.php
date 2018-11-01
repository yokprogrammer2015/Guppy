<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use App\Models\ClearCredit;
use App\Models\DailySale;
use App\Models\Order;
use Illuminate\Http\Request;
use \Validator;

class ServiceController extends Controller
{
    private $order;
    private $dailySale;
    private $agent;
    private $category;
    private $clearCredit;
    protected $getFunction;
    protected $dataSet;
    protected $dataOrder;
    protected $validator;

    public function __construct()
    {
        $this->order = new Order();
        $this->dailySale = new DailySale();
        $this->agent = new Agent();
        $this->category = new Category();
        $this->clearCredit = new ClearCredit();
        $this->getFunction = new AllFunctionController();
        $this->dataSet = [];
        $this->dataOrder = [];
        $this->validator = Validator::make($this->dataSet, []);
    }

    public function dailySale(Request $request)
    {
        $catId = $request->input('catId');
        $branchId = $request->input('branchId');
        $agentId = $request->input('agentId');
        $typeId = $request->input('typeId');
        $book = $request->input('book');
        $no = $request->input('no');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        if ($request->input('offset')) $offset = $request->input('offset'); else $offset = 1;
        if ($request->input('limit')) $limit = $request->input('limit'); else $limit = 50;
        $pickUp = '';
        $dropOff = '';

        $params = ['startDate' => $startDate, 'endDate' => $endDate];

        if ($startDate) {
            $this->validator = Validator::make($params, [
                'startDate' => 'required|date_format:Y-m-d'
            ]);
        }

        if ($endDate) {
            $this->validator = Validator::make($params, [
                'endDate' => 'required|date_format:Y-m-d'
            ]);
        }

        if ($this->validator->fails()) {
            $data = $this->getFunction->getStatusCode(403000);
            $data['required'] = $this->validator->errors();
            return response()->json($data);
        }

        $daily = $this->dailySale->where('ds_id', '<>', '');
        if ($catId) {
            $daily->where('cat_id', $catId);
        }
        if ($branchId) {
            $daily->where('branch_id', $branchId);
        }
        if ($typeId) {
            $daily->where('type_id', $typeId);
        }
        if ($book) {
            $daily->where('ds_book', $book);
        }
        if ($no) {
            $daily->where('ds_no', $no);
        }

        $daily = $daily->orderBy('ds_id', 'asc')->get();

        foreach ($daily as $row) {
            $this->dataOrder[] = $row->order_id;
        }

        $order = $this->order->whereIn('order_id', $this->dataOrder);
        if ($catId) {
            $order->where('cat_id', $catId);
        }
        if ($branchId) {
            $order->where('branch_id', $branchId);
        }
        if ($agentId) {
            $order->where('ag_id', $agentId);
        }
        if ($startDate) {
            $order->where('travel_date', '>=', $startDate);
        }
        if ($endDate) {
            $order->where('travel_date', '<=', $endDate);
        }

        $order = $order->orderBy('travel_date', 'desc')->limit($limit, $offset)->get();

        foreach ($order as $k => $row) {
            if ($row->pick_id) {
                $pickUp = $row->pickUp->con_name;
            }
            if ($row->drop_id) {
                $dropOff = $row->dropOff->con_name;
            }

            $this->dataSet['data'][$k] = [
                'orderId' => $row->order_id,
                'dsBook' => $row->dailySale->ds_book,
                'dsNo' => $row->dailySale->ds_no,
                'catId' => $row->cat_id,
                'catName' => $row->category->con_name,
                'branchId' => $row->branch_id,
                'branchName' => $row->branch->con_name,
                'comCode' => $row->com_code,
                'ticketNo' => $row->ticket_no,
                'depId' => $row->dep_id,
                'depName' => $row->departure->con_name,
                'timeId' => $row->time_id,
                'time' => $row->time->con_name,
                'pickUp' => $pickUp,
                'arrId' => $row->arr_id,
                'arrName' => $row->arrive->con_name,
                'timeToId' => $row->time_to_id,
                'timeTo' => $row->timeTo->con_name,
                'dropOff' => $dropOff,
                'memberId' => $row->mb_id,
                'memberName' => $row->member->mb_name,
                'agentId' => $row->ag_id,
                'agentName' => $row->agent->ag_name,
                'travelDate' => $row->travel_date,
                'adult' => $row->adult,
                'child' => $row->child,
                'bus' => $row->bus,
                'voucherNo' => $row->voucher_no,
                'name' => $row->name,
                'email' => $row->email,
                'netAdult' => $row->net_adult,
                'netChild' => $row->net_child,
                'priceAdult' => $row->price_adult,
                'priceChild' => $row->price_child,
                'remark' => $row->remark,
                'status' => $row->status
            ];
        }

        return response()->json($this->dataSet);
    }
}