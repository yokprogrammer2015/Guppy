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
                                    <a href="{{ url('admin/add/member') }}">
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
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover" role="grid">
                            <thead>
                            <tr role="row" class="bg-primary">
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($member as $k=>$row)
                                <tr role="row">
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $row->mb_name }}</td>
                                    <td>{{ $row->mb_email }}</td>
                                    <td>{{ $row->memberType->name }}</td>
                                    <td>
                                        {!! html_entity_decode($row->status($row->mb_status)) !!}
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/add/member/'.$row->mb_id) }}">
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
    </div>
@stop

@section('css')

@stop

@section('js')

@stop