<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'List Orders';

        return view('order.list', $data);
    }

    public function guppy()
    {
        $data['title'] = 'Add Guppy';

        return view('order.guppy', $data);
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