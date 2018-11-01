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
                <form role="form" action="{{ url('config/save') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="cat_id" id="cat_id" value="destination">
                    <input type="hidden" name="con_id" id="con_id" value="{{ $con_id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Route</label>
                            <select class="form-control" name="rou_id" id="rou_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($route as $row)
                                    <option value="{{ $row->con_id }}"
                                    @if($row->con_id==$rou_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Destination</label>
                            <input type="text" class="form-control" name="con_name" id="con_name"
                                   value="{{ $con_name }}" placeholder="Destination" required>
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