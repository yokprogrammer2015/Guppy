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
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ url('invoice/add') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="form-control" name="cat_id" id="cat_id">
                                        <option value=""> -- Category --</option>
                                        @foreach($category as $row)
                                            <option value="{{ $row->con_id }}" @if($row->con_id==$cat_id){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="ag_id" id="ag_id">
                                        <option value=""> -- Agent --</option>
                                        @foreach($agent as $row)
                                            <option value="{{ $row->ag_id }}" @if($row->ag_id==$ag_id){{ 'selected' }}@endif>{{ $row->ag_name }}</option>
                                        @endforeach
                                    </select>
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
                <div class="box-header with-border bg-info">
                    <h3 class="box-title">{{ $description }}</h3>
                </div>
                <form role="form" action="{{ url('invoice/save') }}" method="post" onsubmit="return checkAgent()">
                    {{ csrf_field() }}
                    <input type="hidden" name="canSubmit" id="canSubmit" value="{{ $ag_id }}">
                    <div class="box-body">
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
                                <tr role="row">
                                    <td>
                                        <input type="checkbox" name="order_id[]" id="order_id"
                                               value="{{ $row->order_id }}">
                                        <input type="hidden" name="ds_id[]" id="ds_id"
                                               value="{{ $row->dailySale->ds_id }}">
                                        <input type="hidden" name="ag_id[]" value="{{ $row->ag_id }}">
                                        <input type="hidden" name="cat_id[]" id="cat_id" value="{{ $row->cat_id }}">
                                        <input type="hidden" name="rou_id[]" id="rou_id" value="{{ $row->dep_id }}">
                                        <input type="hidden" name="rou_id_to[]" id="rou_id_to"
                                               value="{{ $row->arr_id }}">
                                    </td>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $row->travel_date }}</td>
                                    <td>{{ $row->agent->ag_name }}</td>
                                    <td>{{ $row->voucher_no }}</td>
                                    <td>{{ $row->departure->con_name }}</td>
                                    <td>{{ $row->arrive->con_name }}</td>
                                    <td>{{ $row->adult }}</td>
                                    <td>{{ $row->child }}</td>
                                    <td>{{ $row->price_adult }}</td>
                                    <td>{{ $row->price_child }}</td>
                                    <td>{{ $row->net_adult }}</td>
                                    <td>{{ $row->net_child }}</td>
                                    <td>{{ $sell_total }}</td>
                                    <td>{{ $net_total }}</td>
                                    <td>{{ $profit }}</td>
                                    <td>{{ $row->ticket_no }}</td>
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

@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            $("#checkAll").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });
        });

        function checkAgent() {
            var agent = $('#canSubmit').val();
            if (agent) {
                return true
            } else {
                alert('Please select agent');
                return false
            }
        }
    </script>
@stop