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
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <ul>
                        <li>เมื่อลูกค้าทำการชำระเงินเรียบร้อยแล้ว กรุณาระบุวันเวลาที่โอน</li>
                        <li>ทางทีมงานจะจัดส่งสินค้าทันที หลังแจ้งโอนภายใน 24 ชั่วโมง</li>
                        <li>ลูกค้าสามารถติดตามสินค้า ได้ที่เมนูติดตามสินค้า</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $title }}</h3>
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
                <form role="form" action="{{ url('contact/payment/save') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking_id }}">
                    <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer_id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="10%">ธนาคาร</th>
                                    <th>รายละเอียด</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><img src="{{ env('PAYMENT_PATH').'scb.png' }}" alt="ช่องทางการชำระเงิน"></td>
                                    <td>
                                        <p>ธนาคาร : ธนาคารไทยพาณิชย์ (SCB)</p>
                                        <p>เลขที่บัญชี : XXXXXXXXXXXXXXXXXXXXXXXXXXXXX</p>
                                        <p>ชื่อบัญชี : ภุชงค์ บัวสด</p>
                                        <p>ประเภท : บัญชีเงินฝากออมทรัพย์</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label>จำนวนเงิน</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <input type="number" class="form-control" name="amount" id="amount"
                                       value="{{ number_format($amount, 0) }}" placeholder="จำนวนเงิน">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>วันที่โอน</label>
                            <div class="input-group date" id="datePicker">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="payDate"
                                       value="{{ $payDate }}" readonly placeholder="วว/ดด/ปป">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>เวลาที่โอน (โดยประมาณ)</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="time" class="form-control" name="payTime"
                                       placeholder="เวลาที่โอน">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="reset" class="btn btn-warning">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        //Date picker
        $('#datePicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        })
    </script>
@stop