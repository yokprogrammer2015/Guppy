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
                <form role="form" action="{{ url('admin/save/member') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="mb_id" id="mb_id" value="{{ $mb_id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $mb_email }}"
                                   placeholder="Email"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $mb_name }}"
                                   placeholder="Name" required>
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
                            <label>Type</label>
                            <select class="form-control" name="type_id" id="type_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($memberType as $row)
                                    <option value="{{ $row->con_id }}" @if($row->con_id==$type_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="status" id="status"
                                           value="1" @if($mb_status==1){{ 'checked' }}@endif> Hidden Account
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