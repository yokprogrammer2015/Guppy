<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentRequest;
use App\Http\Requests\MemberRequest;
use App\Models\Agent;
use App\Models\Branch;
use App\Models\Member;
use App\Models\MemberType;
use App\Models\Route;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    private $agent;
    private $member;
    private $branch;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->member = new Member();
        $this->branch = new Branch();
    }

    public function agent()
    {
        $data['title'] = 'Agent';
        $data['agent'] = $this->agent->orderBy('ag_name', 'asc')->get();

        return view('admin.agent.list')->with($data);
    }

    public function member()
    {
        $data['title'] = 'Member';
        $data['member'] = $this->member->orderBy('mb_name', 'asc')->get();

        return view('admin.member.list')->with($data);
    }

    public function addAgent($ag_id = 0)
    {
        $data = array('title' => 'Add Agent', 'description' => 'Agent', 'ag_id' => $ag_id, 'ag_name' => '', 'ag_email' => '',
            'branch_id' => '', 'ag_address' => '', 'ag_phone' => '', 'ag_mobile' => '', 'ag_fax' => '', 'ag_status' => 0
        );

        $data['branch'] = $this->branch->orderBy('con_name', 'asc')->get();

        if ($ag_id) {
            $row = $this->agent->where('ag_id', $ag_id)->first();
            $data['ag_name'] = $row->ag_name;
            $data['ag_email'] = $row->ag_email;
            $data['branch_id'] = $row->branch_id;
            $data['ag_address'] = $row->ag_address;
            $data['ag_phone'] = $row->ag_phone;
            $data['ag_mobile'] = $row->ag_mobile;
            $data['ag_fax'] = $row->ag_fax;
            $data['ag_status'] = $row->ag_status;
        }

        return view('admin.agent.add')->with($data);
    }

    public function addMember($mb_id = 0)
    {
        $data = array('title' => 'Add Member', 'description' => 'Member', 'mb_id' => $mb_id, 'branch_id' => '', 'type_id' => '',
            'mb_name' => '', 'mb_email' => '', 'mb_status' => 0);

        $data['branch'] = $this->branch->orderBy('con_name', 'asc')->get();
        $data['memberType'] = MemberType::orderBy('con_name', 'asc')->get();

        if ($mb_id) {
            $row = $this->member->where('mb_id', $mb_id)->first();
            $data['branch_id'] = $row->branch_id;
            $data['type_id'] = $row->type_id;
            $data['mb_name'] = $row->mb_name;
            $data['mb_email'] = $row->mb_email;
            $data['mb_status'] = $row->mb_status;
        }

        return view('admin.member.add')->with($data);
    }

    public function logs()
    {
        return redirect('log-viewer');
    }

    public function saveAgent(AgentRequest $request)
    {
        $ag_id = $request->input('ag_id');
        $ag_mobile = $request->input('mobile');
        $ag_fax = $request->input('fax');
        if ($request->input('status')) $ag_status = $request->input('status'); else $ag_status = 0;

        try {
            $agent = $this->agent;
            if ($ag_id == 0) { // Insert
                $agent->ag_name = $request->agent_name;
                $agent->ag_email = $request->email;
                $agent->branch_id = $request->branch_id;
                $agent->ag_address = $request->address;
                $agent->ag_phone = $request->phone;
                $agent->ag_mobile = $ag_mobile;
                $agent->ag_fax = $ag_fax;
                $agent->ag_status = $ag_status;
                $agent->save();
            } else { // Update
                $agent->where('ag_id', $ag_id)->update([
                    'ag_name' => $request->agent_name,
                    'ag_email' => $request->email,
                    'branch_id' => $request->branch_id,
                    'ag_address' => $request->address,
                    'ag_phone' => $request->phone,
                    'ag_mobile' => $ag_mobile,
                    'ag_fax' => $ag_fax,
                    'ag_status' => $ag_status
                ]);
            }
            Log::info('Admin Save : ' . serialize($request->all()));
            return redirect('admin/agent')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Admin Save : ', $exception);
            return $exception->getMessage();
        }
    }

    public function saveMember(MemberRequest $request)
    {
        $mb_id = $request->input('mb_id');
        if ($request->input('status')) $mb_status = $request->input('status'); else $mb_status = 0;

        try {
            $member = $this->member;
            if ($mb_id == 0) { // Insert
                $member->branch_id = $request->branch_id;
                $member->type_id = $request->type_id;
                $member->mb_name = $request->name;
                $member->mb_email = $request->email;
                $member->mb_password = password_hash($request->password, PASSWORD_DEFAULT);
                $member->mb_status = $mb_status;
                $member->save();
            } else { // Update
                $member->where('mb_id', $mb_id)->update([
                    'branch_id' => $request->branch_id,
                    'type_id' => $request->type_id,
                    'mb_name' => $request->name,
                    'mb_email' => $request->email,
                    'mb_password' => password_hash($request->password, PASSWORD_DEFAULT),
                    'mb_status' => $mb_status
                ]);
            }
            Log::info('Member Save : ' . serialize($request->all()));
            return redirect('admin/member')->with('message', 'Successful!');
        } catch (\Exception $exception) {
            Log::error('Member Save : ', $exception);
            return $exception->getMessage();
        }
    }
}