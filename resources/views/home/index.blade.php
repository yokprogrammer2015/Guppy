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
                    <h3 class="box-title">ค้นหา</h3>
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
                                <th width="15%">สินค้า</th>
                                <th>รายละเอียด</th>
                                <th width="10%">ราคา / 1 ชุด</th>
                                <th width="5%">จำนวน</th>
                                <th width="5%">สั่งซื้อ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order as $k => $row)
                                <tr role="row">
                                    <td>{{ $k+1 }}</td>
                                    <td>
                                        @if($row->pic1)
                                            <img src="{{ '/'.env('THUMBNAIL_PATH').$row->pic1 }}" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->remark }}</td>
                                    <td>{{ $row->price }}</td>
                                    <td>
                                        <select name="" id="">
                                            @for($i=1; $i<=10; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary">สั่งซื้อ</button>
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