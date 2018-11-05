<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentRequest;
use App\Http\Requests\MemberRequest;
use App\Models\Agent;
use App\Models\Amphure;
use App\Models\District;
use App\Models\Member;
use App\Models\MemberType;
use App\Models\Province;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    private $agent;
    private $member;
    private $province;
    private $amphure;
    private $district;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->member = new Member();
        $this->province = new Province();
        $this->amphure = new Amphure();
        $this->district = new District();
    }

    public function member()
    {
        $data['title'] = 'Member';
        $data['member'] = $this->member->orderBy('mb_name', 'asc')->get();

        return view('admin.member.list')->with($data);
    }

    public function addMember($mb_id = 0)
    {
        $data = array('title' => 'Add Member', 'description' => 'Member', 'mb_id' => $mb_id, 'type_id' => '',
            'province_id' => '', 'amphure_id' => '', 'district_id' => '', 'mb_name' => '', 'mb_email' => '', 'id_card' => '', 'mb_status' => 0);

        $data['province'] = $this->province->orderBy('name_th', 'asc')->get();
        $data['amphure'] = $this->amphure->orderBy('name_th', 'asc')->get();
        $data['district'] = $this->district->orderBy('name_th', 'asc')->get();
        $data['memberType'] = MemberType::orderBy('con_name', 'asc')->get();

        if ($mb_id) {
            $row = $this->member->where('mb_id', $mb_id)->first();
            $data['type_id'] = $row->type_id;
            $data['province_id'] = $row->province_id;
            $data['amphure_id'] = $row->amphure_id;
            $data['district_id'] = $row->district_id;
            $data['mb_name'] = $row->mb_name;
            $data['mb_email'] = $row->mb_email;
            $data['id_card'] = $row->id_card;
            $data['mb_status'] = $row->mb_status;
        }

        return view('admin.member.add')->with($data);
    }

    public function saveMember(MemberRequest $request)
    {
        $mb_id = $request->input('mb_id');
        $province_id = $request->input('province_id');
        $amphure_id = $request->input('amphure_id');
        $district_id = $request->input('district_id');
        $id_card = $request->input('id_card');

        if ($request->input('status')) $mb_status = $request->input('status'); else $mb_status = 0;

        try {
            $member = $this->member;
            if ($mb_id == 0) { // Insert
                $member->type_id = $request->type_id;
                $member->province_id = $province_id;
                $member->amphure_id = $amphure_id;
                $member->district_id = $district_id;
                $member->mb_name = $request->name;
                $member->mb_email = $request->email;
                $member->mb_password = password_hash($request->password, PASSWORD_DEFAULT);
                $member->id_card = $id_card;
                $member->mb_status = $mb_status;
                $member->save();
            } else { // Update
                $member->where('mb_id', $mb_id)->update([
                    'type_id' => $request->type_id,
                    'province_id' => $province_id,
                    'amphure_id' => $amphure_id,
                    'district_id' => $district_id,
                    'mb_name' => $request->name,
                    'mb_email' => $request->email,
                    'mb_password' => password_hash($request->password, PASSWORD_DEFAULT),
                    'id_card' => $id_card,
                    'mb_status' => $mb_status
                ]);
            }
            Log::info('Invoice Save : ' . serialize($request->all()));
            return redirect('admin/member')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::info('Invoice Save : ', $exception);
            return $exception->getMessage();
        }
    }
}