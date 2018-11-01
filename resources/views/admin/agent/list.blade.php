@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Search</h3>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="" id="" placeholder="Search">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                                <div class="col-md-7 text-right">
                                    <a href="{{ url('admin/add/agent') }}">
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover" role="grid">
                        <thead>
                        <tr role="row" class="bg-primary">
                            <th>No.</th>
                            <th>Agent</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Mobile</th>
                            <th>Fax</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($agent as $k=>$row)
                            <tr role="row">
                                <td>{{ $k+1 }}</td>
                                <td>{{ $row->ag_name }}</td>
                                <td>{{ $row->ag_address }}</td>
                                <td>{{ $row->ag_phone }}</td>
                                <td>{{ $row->ag_mobile }}</td>
                                <td>{{ $row->ag_fax }}</td>
                                <td>{{ $row->ag_email }}</td>
                                <td>{{ $row->branch->con_name }}</td>
                                <td>{!! html_entity_decode($row->status($row->ag_status)) !!}</td>
                                <td>
                                    <a href="{{ url('admin/add/agent/'.$row->ag_id) }}">
                                        <button type="button" class="btn btn-sm btn-primary">Edit</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop