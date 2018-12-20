<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $payment;
    private $booking;
    private $transport;

    public function __construct()
    {
        $this->payment = new Payment();
        $this->booking = new Booking();
        $this->transport = new Transport();
    }

    public function index()
    {
        $data['title'] = 'สถานะสินค้า';
        $data['keywords'] = 'เช็คสถานะการส่งปลา, รายการส่งปลาหางนกยูง, EMS ส่งปลา, Kerry ส่งปลา';
        $data['description'] = 'สถานะการส่งปลาหางนกยูงวันนี้ ทาง EMS และ Kerry';
        $data['payment'] = $this->payment->orderBy('payDate')->get();

        return view('payment.list', $data);
    }

    public function add($id = null)
    {
        $data['title'] = 'อัพเดทสถานะสินค้า';
        $data['description'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        $data['id'] = $id;
        $data['payment'] = $this->payment->where('id', $id)->get();
        $data['transport'] = $this->transport->orderBy('name')->get();

        return view('payment.add', $data);
    }

    public function remove($id = null)
    {
        if ($id) {
            $this->booking->where('id', $id)->update([
                'status' => 'N'
            ]);
        }

        return redirect('payment/list')->with('message', 'ทำรายการสำเร็จ!');
    }

    public function save(Request $request)
    {
        try {
            $id = $request->input('id');
            $transport_id = $request->input('transport_id');
            $tacking_no = strtoupper($request->input('tacking_no'));

            $this->payment->where('id', $id)->update([
                'transport_id' => $transport_id,
                'tacking_no' => $tacking_no
            ]);

            Log::info('Payment Save : ' . serialize($request->all()));
            return redirect('payment/list')->with('message', 'ทำรายการสำเร็จ!');
        } catch (\Exception $exception) {
            Log::info('Payment Save : ', $exception->getTrace());
            return $exception->getMessage();
        }
    }
}