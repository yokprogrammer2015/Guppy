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
                    <h3 class="box-title">Search</h3>
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
                <form role="form" action="{{ url('booking/list') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="form-control" name="cat_id" id="cat_id">
                                        <option value=""> -- Category --</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="ag_id" id="ag_id">
                                        <option value=""> -- Select --</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="ticket_no" id="ticket_no"
                                           value="" placeholder="Ticket No">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search
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
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                           aria-describedby="example2_info">
                        <thead>
                        <tr role="row" class="bg-primary">
                            <th>ลำดับ</th>
                            <th>รูป</th>
                            <th>สินค้า</th>
                            <th>ราคา</th>
                            <th>วันหมดอายุ</th>
                            <th>Cancel</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order as $k => $row)
                            <tr role="row">
                                <td>{{ $k+1 }}</td>
                                <td>@if($row->pic1)<img src="{{ env('THUMBNAIL_PATH').$row->pic1 }}" alt="">@endif</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->price }}</td>
                                <td>@if($row->type==1){{ $row->expiredDate }}@endif</td>
                                <td>
                                    <a href=""
                                       onclick="return confirm('Are you sure you want to cancel this item?');">
                                        <button type="button" class="btn btn-sm btn-danger">Cancel</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="">
                                        <button type="button" class="btn btn-sm btn-primary">Edit</button>
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