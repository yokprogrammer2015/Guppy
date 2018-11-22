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
                    <h3 class="box-title">{{ $description }}</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                @foreach($payment as $row)
                    <form role="form" action="{{ url('payment/save') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{ $id }}">
                        <input type="hidden" name="booking_id" id="booking_id" value="{{ $row->booking_id }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>เลขที่รายการ</label>
                                <input type="text" class="form-control" name="booking" value="{{ $row->booking_id }}"
                                       readonly placeholder="เลขที่รายการ">
                            </div>
                            <div class="form-group">
                                <label>ชื่อ - นามสกุล</label>
                                <input type="text" class="form-control" name="customer_name"
                                       value="{{ $row->customer->name }}" readonly placeholder="ชื่อ - นามสกุล">
                            </div>
                            <div class="form-group">
                                <label>เลือกขนส่ง</label>
                                <select name="transport_id" id="transport_id" class="form-control" required>
                                    @foreach($transport as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>เลขที่พัสดุ</label>
                                <input type="text" class="form-control" name="tacking_no" required
                                       placeholder="เลขที่พัสดุ">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                            <button type="reset" class="btn btn-warning">ยกเลิก</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop