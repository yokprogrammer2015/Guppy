<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceShipped;
use App\Models\Agent;
use App\Models\Branch;
use App\Models\Category;
use App\Models\ClearCredit;
use App\Models\DailySale;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    private $order;
    private $clearCredit;
    private $dailySale;
    private $agent;
    private $category;
    private $invoice;
    private $invoiceDetail;
    private $branch;
    private $getFunction;
    protected $dataSet;
    protected $dataOrder;
    protected $dataClearCredit;
    protected $dataInvoice;

    public function __construct()
    {
        $this->order = new Order();
        $this->clearCredit = new ClearCredit();
        $this->dailySale = new DailySale();
        $this->agent = new Agent();
        $this->category = new Category();
        $this->invoice = new Invoice();
        $this->invoiceDetail = new InvoiceDetail();
        $this->branch = new Branch();
        $this->getFunction = new AllFunctionController();
        $this->dataOrder = [];
        $this->dataClearCredit = [];
        $this->dataInvoice = [];

        $dailySale = $this->dailySale->where('type_id', 2)->select('order_id')->get(); // Credit
        $clearCredit = $this->clearCredit->get(); // Clear Credit
        $invoice = $this->invoiceDetail->get();

        foreach ($dailySale as $row) {
            $this->dataOrder[] = $row->order_id;
        }

        foreach ($clearCredit as $row) {
            $this->dataClearCredit[] = $row->order_id;
        }

        foreach ($invoice as $row) {
            $this->dataInvoice[] = $row->order_id;
        }
    }

    public function index(Request $request)
    {
        $data['title'] = 'List Invoice';
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['inv_no'] = $request->input('inv_no');
        $mb_id = session('member_id');
        $branch_id = session('branch_id');
        $data['amount'] = 0;

        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        $invoice = $this->invoice->where('inv_id', '<>', '');
        if ($data['cat_id']) {
            $invoice->where('cat_id', $data['cat_id']);
        }
        if ($data['ag_id']) {
            $invoice->where('ag_id', $data['ag_id']);
        }
        if ($data['inv_no']) {
            $invoice->where('inv_no', $data['inv_no']);
        }
        $data['invoice'] = $invoice->where('branch_id', $branch_id)->where('mb_id', $mb_id)->orderBy('inv_id', 'desc')->get();
        $data['invoiceDetail'] = $this->invoiceDetail;

        return view('invoice.list', $data);
    }

    public function add(Request $request)
    {
        $data['title'] = 'Add Invoice';
        $data['description'] = 'Add Invoice';
        $branch_id = session('branch_id');
        $data['cat_id'] = $request->input('cat_id');
        $data['ag_id'] = $request->input('ag_id');
        $data['inv_no'] = $request->input('inv_no');

        $order = $this->order->where('branch_id', $branch_id)->where('status', 0)->whereIn('order_id', $this->dataOrder)->whereNotIn('order_id', $this->dataClearCredit)
            ->whereNotIn('order_id', $this->dataInvoice);
        if ($data['cat_id']) {
            $order->where('cat_id', $data['cat_id']);
        }
        if ($data['ag_id']) {
            $order->where('ag_id', $data['ag_id']);
        }
        $data['order'] = $order->orderBy('order_id', 'desc')->get();
        $data['agent'] = $this->agent->where('branch_id', $branch_id)->orderBy('ag_name', 'asc')->get();
        $data['category'] = $this->category->whereNotIn('con_id', [4])->orderBy('con_name', 'asc')->get();

        return view('invoice.add', $data);
    }

    public function save(Request $request)
    {
        $data = array('title' => 'INVOICE', 'grand_total' => 0, 'ag_name' => '', 'inv_date' => '', 'inv_no' => '',
            'phone' => '', 'mobile' => '', 'fax' => ''
        );
        $order_id = $request->input('order_id');
        $ds_id = $request->input('ds_id');
        $mb_id = session('member_id');
        $branch_id = session('branch_id');
        $ag_id = $request->input('ag_id');
        $cat_id = $request->input('cat_id');
        $rou_id = $request->input('rou_id');
        $rou_id_to = $request->input('rou_id_to');

        try {
            if ($order_id) {
                $inv_id = $this->invoice->insertGetId([
                    'mb_id' => $mb_id,
                    'branch_id' => $branch_id,
                    'cat_id' => $cat_id[0],
                    'ag_id' => $ag_id[0],
                    'inv_date' => now(),
                    'creation_date' => now(),
                    'last_update' => now()
                ]);

                foreach ($order_id as $k => $row) {
                    $this->dataSet[] = [
                        'inv_id' => $inv_id,
                        'inv_no' => date('ym') . str_pad($inv_id, 3, 0, STR_PAD_LEFT),
                        'inv_type' => 'Credit',
                        'order_id' => $row,
                        'ds_id' => $ds_id[$k],
                        'rou_id' => $rou_id[$k],
                        'rou_id_to' => $rou_id_to[$k],
                        'creation_date' => now(),
                        'last_update' => now()
                    ];
                }

                $this->invoice->where('inv_id', $inv_id)->update([
                    'inv_no' => date('ym') . str_pad($inv_id, 3, 0, STR_PAD_LEFT)
                ]);

                DB::table('invoice_detail')->insert($this->dataSet);

                $data['getFunction'] = $this->getFunction;
                $data['invoiceDetail'] = $this->invoiceDetail->where('inv_id', $inv_id)->get();
                $invoice = $this->invoice->where('inv_id', $inv_id)->first();
                if (count($invoice) > 0) {
                    $data['ag_name'] = $invoice->agent->ag_name;
                    $rou_id = $invoice->invoiceDetail->rou_id;
                    $data['inv_date'] = $data['getFunction']->DateFormat($invoice->inv_date, '-');
                    $data['inv_no'] = $invoice->inv_no;

                    $route = $this->branch->where('rou_id', $rou_id)->first();
                    if (count($route) > 0) {
                        $data['phone'] = $route->phone;
                        $data['mobile'] = $route->mobile;
                        $data['fax'] = $route->fax;
                    }

                    $file = env('INVOICE_PATH') . $data['inv_no'] . '.pdf';
                    PDF::loadView('pdf.invoice', $data)->save($file);
                }
            }
            Log::info('Invoice Save : ' . serialize($request->all()));
            return redirect('invoice/list')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Invoice Save : ', $exception);
            return $exception->getMessage();
        }
    }

    public function genInvoice($inv_id = null)
    {
        $data = array('title' => 'INVOICE', 'grand_total' => 0, 'ag_name' => '', 'inv_date' => '', 'inv_no' => '',
            'phone' => '', 'mobile' => '', 'fax' => ''
        );
        $data['getFunction'] = $this->getFunction;
        $data['invoiceDetail'] = $this->invoiceDetail->where('inv_id', $inv_id)->get();
        $invoice = $this->invoice->where('inv_id', $inv_id)->first();
        if (count($invoice) > 0) {
            $data['ag_name'] = $invoice->agent->ag_name;
            $rou_id = $invoice->invoiceDetail->rou_id;
            $data['inv_date'] = $data['getFunction']->DateFormat($invoice->inv_date, '-');
            $data['inv_no'] = $invoice->inv_no;

            $route = $this->branch->where('rou_id', $rou_id)->first();
            if (count($route) > 0) {
                $data['phone'] = $route->phone;
                $data['mobile'] = $route->mobile;
                $data['fax'] = $route->fax;
            }
        }

        $pdf = PDF::loadView('pdf.invoice', $data);
        return @$pdf->stream();
    }

    public function sendMail($inv_id = null)
    {
        try {
            $invoice = $this->invoice->where('inv_id', $inv_id)->first();
            $cc = session('mb_email') ? session('mb_email') : '';

            if (count($invoice) > 0) {
                $email = $invoice->agent->ag_email;
                $mail = Mail::to($email);
                if ($cc) {
                    $mail->cc($cc);
                }
                $mail->bcc('yokprogrammer@gmail.com')->send(new InvoiceShipped($invoice));
            }
            return redirect('invoice/list')->with('message', 'Send Successful!');
        } catch (\Exception $exception) {
            Log::error('Invoice Send Email : ', $exception);
            return $exception->getMessage();
        }
    }
}