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
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ url('booking/save') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}">
                    <input type="hidden" name="numberSet" id="numberSet" value="{{ $numberSet }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>ชื่อ - นามสกุล</label>
                            <input type="text" class="form-control" name="name" placeholder="ชื่อ - นามสกุล">
                        </div>
                        <div class="form-group">
                            <label>เบอร์โทร</label>
                            <input type="text" class="form-control" name="phone" placeholder="เบอร์โทร">
                        </div>
                        <div class="form-group">
                            <label>อีเมล์</label>
                            <input type="email" class="form-control" name="email" placeholder="อีเมล์">
                        </div>
                        <div class="form-group">
                            <label>ที่อยู่จัดส่ง</label>
                            <textarea class="form-control" name="address" cols="30" rows="3"
                                      placeholder="ที่อยู่จัดส่ง"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
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