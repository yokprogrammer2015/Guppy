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
                    <h3 class="box-title">{{ $titleDetail }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" name="travel_date" id="travel_date"
                                                   value="{{ $travel_date }}" placeholder="mm/dd/yyyy"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($bestSeller as $row)
            @php
                $grand_total = $model->grandTotal($getFunction->convertDateFormat($travel_date), $row->dep_id, $row->arr_id);
            @endphp
            <div class="col-md-4">
                <!-- general form elements -->
                <div class="box box-primary text-center">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $row->departure->con_code }} - {{ $row->arrive->con_code }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" role="form" action="{{ url('booking/'.$row->category->con_folder) }}"
                          method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="travel_date" id="travel_date" value="{{ $travel_date }}">
                        <input type="hidden" name="dep_id" id="dep_id" value="{{ $row->dep_id }}">
                        <input type="hidden" name="arr_id" id="arr_id" value="{{ $row->arr_id }}">
                        <input type="hidden" name="time_id" id="time_id" value="{{ $row->time_id }}">
                        <input type="hidden" name="time_to_id" id="time_to_id" value="{{ $row->time_to_id }}">
                        <div class="box-body">
                            <div class="col-md-3 profile-user-img img-responsive img-circle">
                                <h3>{{ $grand_total }}</h3>
                                <p>Booked</p>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Time</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="time"
                                               value="{{ substr($row->time->con_name,0,-3) }} - {{ substr($row->timeTo->con_name,0,-3) }}"
                                               placeholder="Time" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Passenger</label>

                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="adult" id="adult"
                                               placeholder="Adult" maxlength="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Booking</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        @endforeach
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#travel_date').datepicker({
                autoclose: true
            })
        });
    </script>
@stop