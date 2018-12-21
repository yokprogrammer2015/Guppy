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
                <form role="form" action="{{ url('guppy/list') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-control" name="cat_id" id="cat_id">
                                        <option value=""> -- เลือกสายพันธุ์ --</option>
                                        @foreach($category as $row)
                                            <option value="{{ $row->id }}" @if($row->id==$cat_id){{ 'selected' }}@endif>{{ $row->name.' ('.$row->name_th.')' }}</option>
                                        @endforeach
                                        <option value="10">Open (อื่นๆ)</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ $name }}" placeholder="สินค้า">
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
                                <th width="10%">รูป</th>
                                <th width="8%">สายพันธุ์</th>
                                <th width="15%">สินค้า</th>
                                <th>รายละเอียด</th>
                                <th width="10%">จำนวนปลา / ตัว</th>
                                <th width="10%">ราคา / 1 ชุด</th>
                                <th width="7%">จำนวน / ชุด</th>
                                <th width="5%">สั่งซื้อ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order as $k => $row)
                                <tr role="row">
                                    <td>{{ $k+1 }}</td>
                                    <td>
                                        @if($row->pic1)
                                            <img src="{{ '/'.env('THUMBNAIL_PATH').$row->pic1 }}"
                                                 style="cursor: pointer" class="img-thumbnail"
                                                 onclick="getImage({{$row->id.',1'}})">
                                        @endif
                                    </td>
                                    <td>{{ $row->category->name }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{!! $row->remark !!}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->price }}</td>
                                    <td>
                                        <select name="number_set" id="number_set" onchange="numberSet(this.value)">
                                            @for($i=1; $i<=$row->numberSet; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success"
                                                onclick="saveBooking({{$row->id}})">สั่งซื้อ
                                        </button>
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

    <div class="modal fade" id="modal-default" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"></h4>
                    <small>หมายเหตุ ปลาที่ท่านได้รับเป็นปลาสายพันธุ์เดียวกันกับในภาพ
                        จะมีลักษณะคล้ายปลาในภาพนี้แต่ไม่ใช่ปลาตัวนี้
                    </small>
                </div>
                <div class="modal-body">
                    <p id="showImage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                    <button type="button" id="getImage1" class="btn btn-primary">รูปที่ 1</button>
                    <button type="button" id="getImage2" class="btn btn-primary">รูปที่ 2</button>
                    <button type="button" id="getImage3" class="btn btn-primary">รูปที่ 3</button>
                </div>
            </div>
        </div>
    </div>

    <form id="saveBooking" action="{{ url('booking/detail') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="order_id" id="order_id" value="">
        <input type="hidden" name="numberSet" id="numberSet" value="1">
    </form>
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
        });

        function getImage(id, pic) {
            $('#modal-default').modal('show');
            $('.modal-title').html('');
            $('#showImage').html('');
            $.ajax({
                type: 'GET',
                url: '/api/getImageOrder?orderId=' + id,
                dataType: 'json',
                success: function (data) {
                    $.each(data.data, function (index, element) {
                        if (pic == 1 && element.pic1) {
                            $('#showImage').append('<img src="/' + element.pic1 + '" class="img-thumbnail">');
                        }
                        if (pic == 2 && element.pic2) {
                            $('#showImage').append('<img src="/' + element.pic2 + '" class="img-thumbnail">');
                        }
                        if (pic == 3 && element.pic3) {
                            $('#showImage').append('<img src="/' + element.pic3 + '" class="img-thumbnail">');
                        }
                        $('.modal-title').append(element.name);
                        $('#getImage1').attr('onClick', 'getImage(' + id + ',1)');
                        $('#getImage2').attr('onClick', 'getImage(' + id + ',2)');
                        $('#getImage3').attr('onClick', 'getImage(' + id + ',3)');
                    });
                }
            });
        }

        function numberSet(val) {
            $('#numberSet').val(val);
        }

        function saveBooking(order_id) {
            var id = order_id;
            $('#order_id').val(id);
            $('#saveBooking').submit();
        }
    </script>
@stop