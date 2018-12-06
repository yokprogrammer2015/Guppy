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
                    <h3 class="box-title">{{ $title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th width="10%">หัวข้อ</th>
                                <th>รายละเอียด</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>ที่ตั้ง</td>
                                <td>88/124 หมู่ 3 ราชคราม ต.ช้างใหญ่ อ.บางไทร จ.พระนครศรีอยุธยา 13270.</td>
                            </tr>
                            <tr>
                                <td>อีเมล์</td>
                                <td>yokprogrammer@gmail.com</td>
                            </tr>
                            <tr>
                                <td>เบอร์โทรติดต่อ</td>
                                <td>083-8989-572 (คุณหยก)</td>
                            </tr>
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
@stop