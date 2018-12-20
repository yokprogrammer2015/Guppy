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

            $Token = env('LINE_TOKEN');
            $message = 'Booking ID : GT' . $booking_id . ' มีเงินเข้า ' . $amount . ' บาท';

            $this->line_notify($Token, $message);

            Log::info('Payment Save : booking_id | ' . $booking_id . ' | customer_id | ' . $customer_id . ' | amount | ' . $amount . ' | time | ' . $payTime);
            return redirect('guppy/list')->with('message', 'สั่งซื้อสำเร็จ! ทีมงานจะจัดส่งปลาภายใน 24 ชั่วโมง ขอบคุณค่ะ');
        } catch (\Exception $exception) {
            Log::info('Payment Save : ', $exception->getTrace());
            return $exception->getMessage();
        }
    }

    public function contactUs()
    {
        $data['title'] = 'ช่องทางติดต่อเรา';
        $data['keywords'] = 'หาซื้อปลาหางนกยูงเกรดได้ที่ไหน, ต้องการขายปลาหางนกยูงเกรด, ต้องการซื้อปลาหางนกยูงเกรดจำนวนมาก, ช่องทางจัดจำหน่าย, ฟาร์มปลาหางนกยูง';
        $data['description'] = 'ติดต่อซื้อ-ขายปลาหางนกยูงเกรดจำนวนมาก หาซื้อปลาหางนกยูงเกรดได้ที่ไหน ต้องการขายปลาหางนกยูงเกรด';
        return view('contact.contactUs', $data);
    }

    public function line_notify($Token, $message)
    {
        $lineApi = $Token; // ใส่ token key ที่ได้มา
        $mms = trim($message); // ข้อความที่ต้องการส่ง
        date_default_timezone_set("Asia/Bangkok");
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        // SSL USE
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //POST
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$mms");
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineApi . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);
        //Check error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];
        }
        curl_close($chOne);
    }
}