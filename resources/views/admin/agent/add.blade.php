@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border bg-info">
                    <h3 class="box-title">{{ $description }}</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <form role="form" action="{{ url('admin/save/agent') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="ag_id" id="ag_id" value="{{ $ag_id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Agent Name</label>
                            <input type="text" class="form-control" name="agent_name" id="agent_name"
                                   value="{{ $ag_name }}" placeholder="Agent" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $ag_email }}"
                                   placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label>Branch</label>
                            <select class="form-control" name="branch_id" id="branch_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($branch as $row)
                                    <option value="{{ $row->con_id }}" @if($row->con_id==$branch_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" id="address"
                                   value="{{ $ag_address }}" placeholder="Address" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $ag_phone }}"
                                   placeholder="Phone" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" class="form-control" name="mobile" id="mobile" value="{{ $ag_mobile }}"
                                   placeholder="Mobile">
                        </div>
                        <div class="form-group">
                            <label>Fax</label>
                            <input type="text" class="form-control" name="fax" id="fax" value="{{ $ag_fax }}"
                                   placeholder="Fax">
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="status" id="status"
                                           value="1" @if($ag_status==1){{ 'checked' }}@endif> Hidden Agent
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop