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
                                <td>Address</td>
                                <td>88/124 หมู่ 3 ราชคราม ต.ช้างใหญ่ อ.บางไทร จ.พระนครศรีอยุธยา 13270.</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>yokprogrammer@gmail.com</td>
                            </tr>
                            <tr>
                                <td>LINE ID</td>
                                <td>yokprogrammer</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>083-8989-572 (คุณหยก)</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">ติดต่อซื้อปลาจำนวนมาก</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul>
                        <li>ท่านลูกค้าต้องระบุสายพันธุ์ปลาที่ต้องการ</li>
                        <li>ท่านลูกค้าต้องระบุจำนวนปลาที่ต้องการ</li>
                        <li>ท่านลูกค้าต้องบอกงบประมาณที่มี</li>
                        <li>ท่านลูกค้าต้องระบุชื่อ ที่อยู่ หรือสถานที่จัดส่งให้ครบถ้วน</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">ติดต่อขายปลาให้กับเรา</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul>
                        <li>สมาชิกต้องส่งรูปปลาที่ต้องการขายให้กับเราเป็นจำนวน 2 ภาพ ต่อ 1 สายพันธุ์ (ผู้ + เมีย)</li>
                        <li>สมาชิกต้องระบุราคาที่ต้องการขาย ต่อ 1 คู่ (ผู้ + เมีย คิดเฉพาะราคาปลา)</li>
                        <li>สมาชิกต้องระบุเรทราคาส่งปลา เช่น 1-10 คู่ ค่าส่ง 60 บาท 11-20 คู่ ค่าส่ง 100 บาท เป็นต้น
                        </li>
                        <li>สมาชิกต้องระบุชื่อ - นามสกุล หรือถ้ามีชื่อฟาร์มก็ระบุมาด้วย
                            และถ่ายสำเนาบัตรประชาชนส่งมาให้เรา
                        </li>
                        <li>ส่งรายระเอียดมาให้เราได้ที่ yokprogrammer@gmail.com หรือแอดไลน์มาที่ yokprogrammer</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop