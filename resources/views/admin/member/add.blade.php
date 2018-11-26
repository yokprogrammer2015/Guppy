@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border bg-info">
                    <h3 class="box-title">{{ $description }}</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <form role="form" action="{{ url('admin/save/member') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="mb_id" id="mb_id" value="{{ $mb_id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>อีเมล์</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $mb_email }}"
                                   placeholder="อีเมล์"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>รหัสผ่าน</label>
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="รหัสผ่าน" required>
                        </div>
                        <div class="form-group">
                            <label>ชื่อ - นามสกุล</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $mb_name }}"
                                   placeholder="ชื่อ - นามสกุล" required>
                        </div>
                        <div class="form-group">
                            <label>บัตรประจำตัวประชาชน</label>
                            <input type="number" class="form-control" name="id_card" id="id_card" value="{{ $id_card }}"
                                   placeholder="บัตรประจำตัวประชาชน" required>
                        </div>
                        <div class="form-group">
                            <label>จังหวัด</label>
                            <select class="form-control" name="province_id" id="province_id"
                                    onchange="getAmphure(this.value)" required>
                                <option value=""> -- Select --</option>
                                @foreach($province as $row)
                                    <option value="{{ $row->id }}" @if($row->id==$province_id){{ 'selected' }}@endif>{{ $row->name_th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>อำเภอ</label>
                            <select class="form-control" name="amphure_id" id="amphure_id"
                                    onchange="getDistrict(this.value)" required>
                                <option value=""> -- Select --</option>
                                @foreach($amphure as $row)
                                    <option value="{{ $row->id }}" @if($row->id==$amphure_id){{ 'selected' }}@endif>{{ $row->name_th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ตำบล</label>
                            <select class="form-control" name="district_id" id="district_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($district as $row)
                                    <option value="{{ $row->id }}" @if($row->id==$district_id){{ 'selected' }}@endif>{{ $row->name_th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ประเภท</label>
                            <select class="form-control" name="type_id" id="type_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($memberType as $row)
                                    <option value="{{ $row->id }}" @if($row->id==$type_id){{ 'selected' }}@endif>{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="status" id="status"
                                           value="1" @if($mb_status==1){{ 'checked' }}@endif> ปิดบัญชีนี้
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script type="text/javascript">
        function getAmphure(id) {
            $('#amphure_id').html('<option value=""> -- Select --</option>');
            $.ajax({
                type: 'GET',
                url: '/api/amphure/' + id,
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (index, element) {
                        $('#amphure_id').append('<option value="' + element.id + '">' + element.name_th + '</option>');
                    });
                }
            });
        }

        function getDistrict(id) {
            $('#district_id').html('<option value=""> -- Select --</option>');
            $.ajax({
                type: 'GET',
                url: '/api/district/' + id,
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (index, element) {
                        $('#district_id').append('<option value="' + element.id + '">' + element.name_th + '</option>');
                    });
                }
            });
        }
    </script>
@stop