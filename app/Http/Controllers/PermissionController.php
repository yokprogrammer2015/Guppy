<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    private $member;

    public function __construct()
    {
        $this->member = new Member();
    }

    public function checkLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $member = $this->member->where('mb_email', $email)->where('mb_status', 0)->get();

        try {
            if (count($member) > 0) {
                foreach ($member as $val) {
                    if (password_verify($password, $val->mb_password)) {
                        $request->session()->put('member_id', $val->mb_id);
                        $request->session()->put('member_name', $val->mb_name);
                        $request->session()->put('mb_email', $val->mb_email);
                        $request->session()->put('mb_type', $val->type_id);
                        $request->session()->put('branch_id', $val->branch_id);
                        $request->session()->put('route_id', $val->branch->rou_id);

                        return redirect('dashboard');
                    } else {
                        return redirect('login');
                    }
                }
            }
            Log::info('Login : ' . serialize($request->all()));
            return redirect('login');
        } catch (\Exception $exception) {
            Log::error('Login : ', $exception);
            return $exception->getMessage();
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}