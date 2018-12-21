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
                <form role="form" action="{{ url('article/save') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" value="{{ $id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>หัวข้อ</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <input type="text" class="form-control" name="topic" value="{{ $topic }}"
                                       placeholder="หัวข้อ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>รายละเอียด</label>
                            <textarea name="detail" class="form-control" id="detail" cols="30"
                                      rows="5" placeholder="รายละเอียด">{{ $detail }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>รูป</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                                <input type="file" class="form-control" name="pic1" id="pic1">
                                <input type="hidden" name="pic1_val" id="pic1_val" value="{{ $pic1_val }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keywords</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control" name="keywords" id="keywords"
                                       value="{{ $keywords }}">
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

@stop

@section('js')

@stop