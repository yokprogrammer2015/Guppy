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
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('booking/save') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}">
                        <input type="hidden" name="cat_id" id="cat_id" value="3">
                        <input type="hidden" name="cat_name" id="cat_name" value="bus">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Confirm Code</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-ticket"></i>
                                            </div>
                                            <input type="input" class="form-control" name="com_code" id="com_code"
                                                   value="{{ $com_code }}" placeholder="Confirm Code" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Ticket No</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-ticket"></i>
                                            </div>
                                            <input type="input" class="form-control" name="ticket_no" id="ticket_no"
                                                   value="{{ $ticket_no }}" placeholder="Ticket No" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status" value="1" checked
                                                       onclick="getStatus(this.value)">
                                                <strong>Standard</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status" value="2"
                                                       @if($bus){{ 'checked' }}@endif onclick="getStatus(this.value)">
                                                <strong>Private</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Departure</label>
                                        <div class="form-group">
                                            <select class="selectpicker form-control" name="dep_id" id="dep_id"
                                                    onchange="getDestination('pickUp_id', this.value)"
                                                    data-live-search="true" required>
                                                <option value=""> -- Select --</option>
                                                @foreach($route as $row)
                                                    <option value="{{ $row->con_id }}" @if($row->con_id==$dep_id || $row->con_id==session('route_id')){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Time</label>
                                        <select class="form-control" name="time_id" id="time_id" required>
                                            <option value=""> -- Select --</option>
                                            @foreach($time as $row)
                                                <option value="{{ $row->con_id }}" @if($row->con_id==$time_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Pick Up</label>
                                        <select class="form-control" name="pickUp_id" id="pickUp_id">
                                            <option value=""> -- Select --</option>
                                            @foreach($destination as $row)
                                                <option value="{{ $row->con_id }}" @if($row->con_id==$pick_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Arrive</label>
                                        <div class="form-group">
                                            <select class="selectpicker form-control" name="arr_id" id="arr_id"
                                                    onchange="getDestination('dropOff_id', this.value)"
                                                    data-live-search="true" required>
                                                <option value=""> -- Select --</option>
                                                @foreach($route as $row)
                                                    <option value="{{ $row->con_id }}" @if($row->con_id==$arr_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Time</label>
                                        <select class="form-control" name="time_to_id" id="time_to_id">
                                            <option value=""> -- Select --</option>
                                            @foreach($time as $row)
                                                <option value="{{ $row->con_id }}" @if($row->con_id==$time_to_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Drop Off</label>
                                        <select class="form-control" name="dropOff_id" id="dropOff_id">
                                            <option value=""> -- Select --</option>
                                            @foreach($destination as $row)
                                                <option value="{{ $row->con_id }}" @if($row->con_id==$drop_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="travel_type" id="travel_type" value="1" checked=""
                                               onclick="getTravel(1)">
                                        <strong>Fix Date</strong>
                                    </label>
                                    &nbsp;
                                    <label>
                                        <input type="radio" name="travel_type" id="travel_type" value="2"
                                               onclick="getTravel(2)">
                                        <strong>Open</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" name="travel_date" id="travel_date"
                                           value="{{ $travel_date }}" placeholder="mm/dd/yyyy" autocomplete="off"
                                           required>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4" @if(!$bus)id="getBus"@endif>
                                        <label>Bus</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-bus"></i>
                                            </div>
                                            <input type="number" class="form-control" name="bus" id="bus"
                                                   value="{{ $bus }}" placeholder="Bus">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Passenger / Adult</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <input type="number" class="form-control" name="adult" id="adult"
                                                   value="{{ $adult }}" placeholder="Adult" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Passenger / Child</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <input type="number" class="form-control" name="child" id="child"
                                                   value="{{ $child }}" onchange="getChild()" placeholder="Child">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Agent</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <select class="form-control" name="ag_id" id="ag_id">
                                        <option value=""> -- Select --</option>
                                        @foreach($agent as $row)
                                            <option value="{{ $row->ag_id }}" @if($row->ag_id==$ag_id){{ 'selected' }}@endif>{{ $row->ag_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Voucher</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-file-pdf-o"></i>
                                    </div>
                                    <input type="text" class="form-control" name="voucher_no" id="voucher_no"
                                           value="{{ $voucher_no }}" placeholder="Voucher No">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ $name }}" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-paper-plane-o"></i>
                                    </div>
                                    <input type="text" class="form-control" name="email" id="email"
                                           value="{{ $email }}" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Net / Adult</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <input type="number" class="form-control" name="net_adult"
                                                   id="net_adult" value="{{ $net_adult }}" placeholder="Net Adult">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Net / Child</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <input type="number" class="form-control" name="net_child"
                                                   id="net_child" value="{{ $net_child }}" placeholder="Net Child">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Price / Adult</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <input type="number" class="form-control" name="price_adult"
                                                   id="price_adult" value="{{ $price_adult }}" placeholder="Adult">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Price / Child</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <input type="number" class="form-control" name="price_child"
                                                   id="price_child" value="{{ $price_child }}" placeholder="Child">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Remark</label>
                                <textarea class="form-control" name="remark" id="remark" cols="30" rows="3"
                                          placeholder="Remark">{{ $remark }}</textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
            $('#getBus').css('display', 'none');
            $('#travel_date').datepicker({
                autoclose: true
            })
        })

        function getStatus(val) {
            let id = val;
            if (id == 2) {
                $('#getBus').css('display', 'block');
            } else {
                $('#getBus').css('display', 'none');
            }
        }

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