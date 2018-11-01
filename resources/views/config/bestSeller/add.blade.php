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
                <form role="form" action="{{ url('config/saveBestSeller') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="con_id" id="con_id" value="{{ $con_id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="cat_id" id="cat_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($category as $row)
                                    <option value="{{ $row->con_id }}"
                                    @if($row->con_id==$cat_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Departure</label>
                            <select class="form-control" name="dep_id" id="dep_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($route as $row)
                                    <option value="{{ $row->con_id }}"
                                    @if($row->con_id==$dep_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Arrive</label>
                            <select class="form-control" name="arr_id" id="arr_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($route as $row)
                                    <option value="{{ $row->con_id }}"
                                    @if($row->con_id==$arr_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Time</label>
                            <select class="form-control" name="time_id" id="time_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($time as $row)
                                    <option value="{{ $row->con_id }}"
                                    @if($row->con_id==$time_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Time To</label>
                            <select class="form-control" name="time_to_id" id="time_to_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($time as $row)
                                    <option value="{{ $row->con_id }}"
                                    @if($row->con_id==$time_to_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
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