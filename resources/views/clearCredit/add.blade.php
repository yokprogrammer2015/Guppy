@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }} {{ '<'.$description.'>' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Search</h3>
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
                <form role="form" action="{{ url('clear/'.$type_id) }}" method="post">
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
                                    <input type="text" class="form-control" name="inv_no" id="inv_no"
                                           value="{{ $inv_no }}" placeholder="Invoice No">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form role="form" action="{{ url('clear/save') }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover" role="grid">
                            <thead>
                            <tr role="row" class="bg-primary">
                                <th><input type="checkbox" name="" id="checkAll"></th>
                                <th>No.</th>
                                <th>Invoice No</th>
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
                                @if($row->invoiceDetail)
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
                                        </td>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $row->invoiceDetail->inv_no }}</td>
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
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border bg-info">
                        <h3 class="box-title">{{ $titleDetail }}</h3>
                    </div>
                    <input type="hidden" name="credit_type_id" id="credit_type_id" value="{{ $credit_type_id }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Bank</label>
                            <select class="form-control" name="bank_id" id="bank_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($bank as $row)
                                    <option value="{{ $row->con_id }}">{{ $row->con_name }} ({{ $row->con_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Branch</label>
                            <select class="form-control" name="branch_id" id="branch_id" required>
                                <option value=""> -- Select --</option>
                                @foreach($branch as $row)
                                    <option value="{{ $row->con_id }}" @if($row->con_id==session('branch_id')){{ 'selected' }}@endif>{{ $row->con_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ref No</label>
                            <input type="text" class="form-control" name="ref_no" id="ref_no" placeholder="Ref No"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="clear_date" id="clear_date"
                                       value="{{ $clear_date }}" placeholder="mm/dd/yyyy" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount"
                                   required>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

            $('#clear_date').datepicker({
                autoclose: true
            })
        });
    </script>
@stop