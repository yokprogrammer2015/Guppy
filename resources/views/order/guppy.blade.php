@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="box box-primary">
                    <div class="box-header with-border bg-info">
                        <h3 class="box-title"></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('order/save') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="order_id" id="order_id" value="">
                        <input type="hidden" name="cat_id" id="cat_id" value="1">
                        <input type="hidden" name="cat_name" id="cat_name" value="boat">
                        <div class="box-body">
                            <div class="form-group">
                                <label>หัวข้อสินค้า</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bullhorn"></i>
                                    </div>
                                    <input class="form-control" type="text" name="name" id="name" value=""
                                           placeholder="หัวข้อสินค้า">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="type" id="type" value="1" checked=""
                                               onclick="getTravel(1)">
                                        <strong>กำหนดวัน</strong>
                                    </label>
                                    &nbsp;
                                    <label>
                                        <input type="radio" name="type" id="type" value="2"
                                               onclick="getTravel(2)">
                                        <strong>ไม่กำหนดวัน</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>วันที่ปิด:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" name="expiredDate" id="expiredDate"
                                           value="" placeholder="mm/dd/yyyy" autocomplete="off"
                                           required>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>ราคา</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-dollar"></i>
                                    </div>
                                    <input type="number" class="form-control" name="price" id="price"
                                           value="" placeholder="ราคา">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>รูปภาพ 1</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                                            <input type="file" class="form-control" name="pic1" id="pic1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>รูปภาพ 2</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                                            <input type="file" class="form-control" name="pic2" id="pic2" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>รูปภาพ 3</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                                            <input type="file" class="form-control" name="pic3" id="pic3" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>รายละเอียด</label>
                                <textarea class="form-control" name="remark" id="remark" cols="30" rows="3"
                                          placeholder="รายละเอียด"></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-select.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#expiredDate').datepicker({
                autoclose: true
            })
        });

        function getDestination(id, val) {
            $('#' + id).html('<option value=""> -- Select --</option>');
            $.ajax({
                type: 'GET',
                url: '/ajax/getDestination/' + val,
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (k, v) {
                        $('#' + id).append('<option value=' + v.con_id + '>' + v.con_name + '</option>');
                    });
                }
            });
        }

        function getTravel(val) {
            if (val == 2) {
                $('#travel_date').prop('readonly', true);
            } else {
                $('#travel_date').prop('readonly', false);
            }
        }

        function getChild() {
            $('#net_child').prop('required', true);
            $('#price_child').prop('required', true);
        }
    </script>
@stop