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
                <form role="form" action="{{ url('config/category') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Search">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                                <div class="col-md-7 text-right">
                                    <a href="{{ url('config/add/category') }}">
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
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover" role="grid">
                            <thead>
                            <tr role="row" class="bg-primary">
                                <th>No.</th>
                                <th>Name</th>
                                <th>Name TH</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($category as $k=>$row)
                                <tr role="row">
                                    <td width="5%">{{ $k+1 }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->name_th }}</td>
                                    <td width="5%">
                                        <a href="{{ url('config/add/category/'.$row->id) }}">
                                            <button type="button" class="btn btn-sm btn-primary">Edit</button>
                                        </a>
                                    </td>
                                    <td width="5%">
                                        <a href="{{ url('config/remove/category/'.$row->id) }}"
                                           onclick="return confirm('Are you sure you want to delete this item?');">
                                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
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