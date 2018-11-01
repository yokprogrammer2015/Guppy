<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClearRequest;
use App\Models\Agent;
use App\Models\Bank;
use App\Models\Category;
use App\Models\ClearCredit;
use App\Models\DailySale;
use App\Models\InvoiceDetail;
use App\Models\Order;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyClearController extends Controller
{
    private $order;
    private $clearCredit;
    private $dailySale;
    private $bank;
    private $agent;
    private $route;
    private $category;
    private $invoiceDetail;
    protected $getFunction;
    protected $dataSet;
    protected $dataInvoice;
    protected $dataOrder;
    protected $dataClearCredit;

    public function __construct()
    {
        $this->order = new Order();
        $this->clearCredit = new ClearCredit();
        $this->dailySale = new DailySale();
        $this->bank = new Bank();
        $this->route = new Route();
        $this->agent = new Agent();
        $this->category = new Category();
        $this->invoiceDetail = new InvoiceDetail();
        $this->getFunction = new AllFunctionController();
        $this->dataOrder = [];
        $this->dataClearCredit = [];

        $dailySale = $this->dailySale->where('type_id', 2)->select('order_id')->get(); // Credit
        $clearCredit = $this->clearCredit->orderBy('clear_id', 'asc')->get(); // Clear Credit

        foreach ($dailySale as $row) {
            $this->dataOrder[] = $row->order_id;
        }

        foreach ($clearCredit as $row) {
            $this->dataClearCredit[] = $row->order_id;
        }
    }

    public function index(Request $request)
    {
        $data['title'] = 'List Daily Sale Clear Credit';
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['inv_no'] = $request->input('inv_no');
        $data['ds_book'] = $request->input('ds_book');
        $data['ds_no'] = $request->input('ds_no');
        $branch_id = session('branch_id');
        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        if ($data['inv_no']) {
            $inv_no = explode(',', $data['inv_no']);
            $this->dataOrder = [];
            $invoice = $this->invoiceDetail->whereIn('inv_no', $inv_no)->get();
            foreach ($invoice as $row) {
                $this->dataOrder[] = $row->order_id;
            }
        }

        if ($data['ds_book'] || $data['ds_no']) {
            $this->dataOrder = [];
            $daily = $this->dailySale->where('branch_id', $branch_id)->where('ds_book', $data['ds_book'])->orWhere('ds_no', $data['ds_no'])->get();
            foreach ($daily as $row) {
                $this->dataOrder[] = $row->order_id;
            }
        }

        $order = $this->order->where('branch_id', $branch_id)->whereIn('order_id', $this->dataClearCredit);
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['ag_id']) {
            $order->where('ag_id', $data['ag_id']);
        }
        if ($data['inv_no']) {
            $order->whereIn('order_id', $this->dataOrder);
        }
        if ($data['ds_book'] || $data['ds_no']) {
            $order->whereIn('order_id', $this->dataOrder);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();

        return view('clearCredit.list', $data);
    }

    public function cash(Request $request)
    {
        $data = array('title' => 'Daily Sale Clear Credit', 'description' => 'Cash', 'type_id' => 'cash', 'titleDetail' => 'Pay In Details',
            'credit_type_id' => 1, 'clear_date' => date('m/d/Y')
        );
        $branch_id = session('branch_id');
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['inv_no'] = $request->input('inv_no');

        if ($data['inv_no']) {
            $inv_no = explode(',', $data['inv_no']);
            $this->dataOrder = [];
            $invoice = $this->invoiceDetail->whereIn('inv_no', $inv_no)->get();
            foreach ($invoice as $row) {
                $this->dataOrder[] = $row->order_id;
            }
        }

        $order = $this->order->where('branch_id', $branch_id)->where('status', 0)->whereIn('order_id', $this->dataOrder)->whereNotIn('order_id', $this->dataClearCredit);
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['ag_id']) {
            $order->where('ag_id', $data['ag_id']);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();
        $data['bank'] = $this->bank->orderBy('con_name', 'asc')->get();
        $data['branch'] = $this->route->orderBy('con_name', 'asc')->get();
        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        return view('clearCredit.add', $data);
    }

    public function check(Request $request)
    {
        $data = array('title' => 'Daily Sale Clear Credit', 'description' => 'Check', 'type_id' => 'check', 'titleDetail' => 'Pay In Details',
            'credit_type_id' => 2, 'clear_date' => date('m/d/Y')
        );
        $branch_id = session('branch_id');
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['inv_no'] = $request->input('inv_no');

        if ($data['inv_no']) {
            $inv_no = explode(',', $data['inv_no']);
            $this->dataOrder = [];
            $invoice = $this->invoiceDetail->whereIn('inv_no', $inv_no)->get();
            foreach ($invoice as $row) {
                $this->dataOrder[] = $row->order_id;
            }
        }

        $order = $this->order->where('branch_id', $branch_id)->where('status', 0)->whereIn('order_id', $this->dataOrder)->whereNotIn('order_id', $this->dataClearCredit);
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['ag_id']) {
            $order->where('ag_id', $data['ag_id']);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();
        $data['bank'] = $this->bank->orderBy('con_name', 'asc')->get();
        $data['branch'] = $this->route->orderBy('con_name', 'asc')->get();
        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        return view('clearCredit.add', $data);
    }

    public function save(ClearRequest $request)
    {
        $order_id = $request->input('order_id');
        $ds_id = $request->input('ds_id');
        $credit_type_id = $request->input('credit_type_id');
        if ($credit_type_id == 1) $inv_type = 'Cash'; else $inv_type = 'Check';

        try {
            if ($order_id) {
                foreach ($order_id as $k => $row) {
                    $this->dataSet[] = [
                        'order_id' => $row,
                        'ds_id' => $ds_id[$k],
                        'credit_type_id' => $credit_type_id,
                        'bank_id' => $request->bank_id,
                        'branch_id' => $request->branch_id,
                        'ref_no' => $request->ref_no,
                        'clear_date' => $this->getFunction->convertDateFormat($request->clear_date),
                        'amount' => $request->amount,
                        'creation_date' => now(),
                        'last_update' => now()
                    ];

                    DB::table('invoice_detail')->where('order_id', $row)->update([
                        'inv_type' => $inv_type
                    ]);
                }

                DB::table('clear_credit')->insert($this->dataSet);
            }
            Log::info('Clear Save : ' . serialize($request->all()));
            return redirect('clear/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Clear Save : ', $exception);
            return $exception->getMessage();
        }
    }
}