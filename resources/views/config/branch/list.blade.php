@extends('adminlte::page')

@section('title', $description)

@section('content_header')
    <h1>{{ $title }} {{ $description }}</h1>
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
                                    <a href="{{ url('config/add/branch') }}">
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
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $description }}</h3>
                </div>
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover" role="grid">
                        <thead>
                        <tr role="row" class="bg-primary">
                            <th>No.</th>
                            <th>Branch</th>
                            <th>Route</th>
                            <th>Phone</th>
                            <th>Mobile</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($branch as $k=>$row)
                            <tr role="row">
                                <td width="5%">{{ $k+1 }}</td>
                                <td>{{ $row->con_name }}</td>
                                <td width="20%">{{ $row->route->con_name }}</td>
                                <td width="10%">{{ $row->phone }}</td>
                                <td width="10%">{{ $row->mobile }}</td>
                                <td width="5%">
                                    <a href="{{ url('config/add/branch/'.$row->con_id) }}">
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