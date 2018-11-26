<?php

namespace App\Http\Controllers;

use App\Helpers\AllFunction;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $data['amount'] = $request->input('amount');
        $data['payDate'] = date('d/m/Y');

        return view('contact.payment', $data);
    }

    public function save(PaymentRequest $request)
    {
        try {
            $booking_id = $request->input('booking_id');
            $customer_id = $request->input('customer_id');
            $amount = $request->amount;
            if ($request->payDate) $payDate = $this->allFunction->convertDateFormat($request->payDate); else $payDate = '0000-00-00';
            $payTime = $request->payTime;

            $this->payment->insert([
                'booking_id' => $booking_id,
                'customer_id' => $customer_id,
                'amount' => $amount,
                'payDate' => $payDate,
                'payTime' => $payTime,
                'transport_id' => 1,
                'tacking_no' => '',
                'creation_date' => now(),
                'last_update' => now()
            ]);

            Log::info('Payment Save : ', serialize($request->all()));
            return redirect('guppy/list')->with('message', 'สั่งซื้อสำเร็จ! ทีมงานจะจัดส่งปลาภายใน 24 ชั่วโมง ขอบคุณค่ะ');
        } catch (\Exception $exception) {
            Log::info('Payment Save : ', $exception->getTrace());
            return $exception->getMessage();
        }
    }
}