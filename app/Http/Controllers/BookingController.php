<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $booking;
    private $customer;
    private $order;
    protected $setData = [];

    public function __construct()
    {
        $this->booking = new Booking();
        $this->customer = new Customer();
        $this->order = new Order();
    }

    public function bookingDetail(Request $request)
    {
        $data['title'] = 'ข้อมูลลูกค้า';
        $data['description'] = 'กรุณากรอกข้อมูลให้ถูกต้อง';
        $data['order_id'] = $request->input('order_id');
        $data['numberSet'] = $request->input('numberSet');

        return view('booking.detail', $data);
    }

    public function save(BookingRequest $request)
    {
        $order_id = $request->input('order_id');
        $numberSet = $request->input('numberSet');
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $address = $request->address;
        $amount = 0;

        if ($order_id) {
            $order = $this->order->select('price')->where('id', $order_id)->first();
            if (count($order)) {
                $amount = $order->price * $numberSet;
            }
        }

        $customer_id = $this->customer->insertGetId([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'creation_date' => now(),
            'last_update' => now()
        ]);

        $booking_id = $this->booking->insertGetId([
            'order_id' => $order_id,
            'customer_id' => $customer_id,
            'qty' => $numberSet,
            'amount' => $amount,
            'status' => 'Y',
            'creation_date' => now(),
            'last_update' => now()
        ]);

        $this->order->where('id', $order_id)->decrement('numberSet', $numberSet);

        return redirect('payment?bookingId=' . $booking_id . '&customerId=' . $customer_id . '&amount=' . $amount)->with('message', 'สั่งซื้อสำเร็จ!');
    }
}