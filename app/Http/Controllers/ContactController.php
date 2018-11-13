<?php

namespace App\Http\Controllers;

use App\Helpers\AllFunction;
use App\Models\Payment;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $payment;
    private $allFunction;

    public function __construct()
    {
        $this->payment = new Payment();
        $this->allFunction = new AllFunction();
    }

    public function payment(Request $request)
    {
        $data['title'] = 'ช่องทางการชำระเงิน';
        $data['description'] = 'กรุณาอ่านรายละเอียดเพิ่มเติมด้านล่าง';
        $data['booking_id'] = $request->input('bookingId');
        $data['customer_id'] = $request->input('customerId');
        $data['payDate'] = date('d/m/Y');

        return view('contact.payment', $data);
    }

    public function save(Request $request)
    {
        $booking_id = $request->input('booking_id');
        $customer_id = $request->input('customer_id');
        $amount = $request->input('amount');
        if ($request->input('payDate')) $payDate = $this->allFunction->convertDateFormat($request->input('payDate')); else $payDate = '0000-00-00';
        $payTime = $request->input('payTime');

        $this->payment->insert([
            'booking_id' => $booking_id,
            'customer_id' => $customer_id,
            'amount' => $amount,
            'payDate' => $payDate,
            'payTime' => $payTime,
            'tacking' => '',
            'creation_date' => now(),
            'last_update' => now()
        ]);

        return redirect('guppy/list')->with('message', 'สั่งซื้อสำเร็จ!');
    }
}