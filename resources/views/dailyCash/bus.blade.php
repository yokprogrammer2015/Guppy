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
                <form role="form" action="{{ url('daily/cash/bus') }}" method="post">
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
                                                   placeholder="mm/dd/yyyy" value="{{ $travel_date }}"
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
                <form role="form" action="{{ url('daily/cash/save') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-footer">
                        <table id="example2" class="table table-bordered table-hover" role="grid">
                            <thead>
                            <tr role="row" class="bg-primary">
                                <th><input type="checkbox" name="" id="checkAll"></th>
                                <th>No.</th>
                                <th>Travel Date</th>
                                <th>Agent</th>
                                <th>Voucher No</th>
                                <th>Dep</th>
                                <th>Arr</th>
                                <th>Adult</th>
                                <th>Child</th>
                                <th>Sell Adult</th>
                                <th>Sell Child</th>
                                <th>Net Adult</th>
                                <th>Net Child</th>
                                <th>Sell Total</th>
                                <th>Net Total</th>
                                <th>Profit</th>
                                <th>Ticket No</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order as $k => $row)
                                @php
                                    $sell_total = (int)($row->adult * $row->price_adult) + ($row->child * $row->price_child);
                                    $net_total = (int)($row->adult * $row->net_adult) + ($row->child * $row->net_child);
                                    $profit = (int)($sell_total - $net_total);
                                @endphp
                                <input type="hidden" name="cat_id" id="cat_id" value="3">
                                <tr role="row">
                                    <td><input type="checkbox" name="order_id[]" id="order_id"
                                               value="{{ $row->order_id }}"></td>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $row->travel_date }}</td>
                                    <td>{{ $row->agent->ag_name }}</td>
                                    <td>{{ $row->voucher_no }}</td>
                                    <td>{{ $row->departure->con_name }}</td>
                                    <td>{{ $row->arrive->con_name }}</td>
                                    <td>{{ $row->adult }}</td>
                                    <td>{{ $row->child }}</td>
                                    <td><input type="number" class="form-control" name="price_adult[]"
                                               id="price_adult"
                                               value="{{ $row->price_adult }}"></td>
                                    <td><input type="number" class="form-control" name="price_child[]" id="price_child"
                                               value="{{ $row->price_child }}"></td>
                                    <td><input type="number" class="form-control" name="net_adult[]" id="net_adult"
                                               value="{{ $row->net_adult }}"></td>
                                    <td><input type="number" class="form-control" name="net_child[]" id="net_child"
                                               value="{{ $row->net_child }}"></td>
                                    <td>{{ $sell_total }}</td>
                                    <td>{{ $net_total }}</td>
                                    <td>{{ $profit }}</td>
                                    <td><input type="text" class="form-control" name="ticket_no[]" id="ticket_no"
                                               value="{{ $row->ticket_no }}" maxlength="10"></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="17" class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $("#checkAll").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });

            $('#travel_date').datepicker({
                autoclose: true
            })
        });
    </script>
@stop