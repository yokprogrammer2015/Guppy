@extends('adminlte::page')

@section('title', $title)
@section('keywords', $keywords)
@section('description', $description)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">ค้นหา</h3>
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
                <form role="form" action="{{ url('payment/list') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="" placeholder="ชื่อลูกค้า">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา
                                    </button>
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
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                               aria-describedby="example2_info">
                            <thead>
                            <tr role="row" class="bg-primary">
                                <th width="5%">ลำดับ</th>
                                <th width="10%">เลขที่รายการ</th>
                                <th>ลูกค้า</th>
                                <th width="8%">ราคา</th>
                                <th width="10%">วัน เวลา</th>
                                <th width="8%">ขนส่ง</th>
                                <th width="7%">เลขพัสดุ</th>
                                <th width="10%">สถานะ</th>
                                @if(session('mb_type')==1)
                                    <th width="7%">ปิดการขาย</th>
                                    <th width="5%">แก้ไข</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payment as $k => $row)
                                <tr role="row">
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ 'GT'.$row->booking_id }}</td>
                                    <td>{{ $row->customer->name }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td>{{ $row->payDate.' '.$row->payTime }}</td>
                                    <td>{{ $row->transport->name }}</td>
                                    <td>{{ $row->tacking_no }}</td>
                                    <td>{!! $row->getStatus($row->booking->status) !!}</td>
                                    @if(session('mb_type')==1)
                                        <td>
                                            @if($row->booking->status=='Y')
                                                <a href="{{ url('payment/remove/'.$row->booking_id) }}">
                                                    <button type="button" class="btn btn-sm btn-danger">ปิดการขาย
                                                    </button>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('payment/add/'.$row->id) }}">
                                                <button type="button" class="btn btn-sm btn-primary">แก้ไข</button>
                                            </a>
                                        </td>
                                    @endif
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
    <script>
        $(function () {
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
@stop