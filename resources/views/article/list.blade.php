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
                <form role="form" action="{{ url('article/list') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="topic" id="topic"
                                           value="{{ $topic }}" placeholder="หัวข้อ">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา
                                    </button>
                                </div>
                                @if(session('mb_type')==1)
                                    <a href="{{ url('article/add') }}">
                                        <div class="col-md-1 pull-right">
                                            <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>
                                                เพิ่มบทความ
                                            </button>
                                        </div>
                                    </a>
                                @endif
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
                                <th width="15%">หัวข้อ</th>
                                <th>รายละเอียด</th>
                                <th width="10%">วันที่ประกาศ</th>
                                @if(session('mb_type')==1)
                                    <th width="7%">ลบ</th>
                                    <th width="5%">แก้ไข</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($article as $k => $row)
                                <tr role="row">
                                    <td>{{ $k+1 }}</td>
                                    <td>
                                        @if($row->pic1)
                                            <img src="{{ '/'.env('THUMBNAIL_PATH').$row->pic1 }}"
                                                 style="cursor: pointer" class="img-thumbnail"
                                                 onclick="getImage({{$row->id.',1'}})">
                                        @endif
                                    </td>
                                    <td>{{ $row->topic }}</td>
                                    <td>{!! $row->detail !!}</td>
                                    <td>{{ $row->creation_date }}</td>
                                    @if(session('mb_type')==1)
                                        <td>
                                            <a href="{{ url('article/remove/'.$row->id) }}">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                    ลบ
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('article/add/'.$row->id) }}">
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

    <div class="modal fade" id="modal-default" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p id="showDetail"></p>
                    <p id="showImage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
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
        });

        function getImage(id) {
            $('#modal-default').modal('show');
            $('.modal-title').html('');
            $('#showImage').html('');
            $.ajax({
                type: 'GET',
                url: '/api/getImageArticle?articleId=' + id,
                dataType: 'json',
                success: function (data) {
                    $.each(data.data, function (index, element) {
                        $('#showDetail').append(element.detail);
                        $('#showImage').append('<img src="/' + element.pic1 + '" class="img-thumbnail">');
                        $('.modal-title').append(element.topic);
                    });
                }
            });
        }
    </script>
@stop