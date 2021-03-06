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
                <form role="form" action="{{ url('order/list') }}" method="post">
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
                                    <select class="form-control" name="status" id="status">
                                        <option value=""> -- เลือกสถานะ --</option>
                                        <option value="Y" @if($status=='Y'){{ 'selected' }}@endif>เปิดใช้งาน</option>
                                        <option value="N" @if($status=='N'){{ 'selected' }}@endif>ปิดใช้งาน</option>
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
                                <th>สินค้า</th>
                                <th width="10%">จำนวนปลา / ตัว</th>
                                <th width="8%">คงเหลือ / ชุด</th>
                                <th width="7%">ราคา</th>
                                <th width="7%">สถานะ</th>
                                <th width="7%">ปิดการขาย</th>
                                <th width="5%">แก้ไข</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order as $k => $row)
                                @php $status = $getFunction->getStatusCode($row->status) @endphp
                                <tr role="row">
                                    <td>{{ $k+1 }}</td>
                                    <td>
                                        @if($row->pic1)
                                            <img src="{{ '/'.env('THUMBNAIL_PATH').$row->pic1 }}" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>{{ $row->category->name }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->numberSet }}</td>
                                    <td>{{ $row->price }}</td>
                                    <td>{!! $status !!}</td>
                                    <td>
                                        <a href="{{ url('order/remove/'.$row->id) }}"
                                           onclick="return confirm('Are you sure you want to cancel this item?');">
                                            <button type="button" class="btn btn-sm btn-danger">ปิดการขาย</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('order/guppy/'.$row->id) }}">
                                            <button type="button" class="btn btn-sm btn-primary">แก้ไข</button>
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