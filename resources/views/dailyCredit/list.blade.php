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
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ url('daily/credit/list') }}" method="post">
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
                                    <input type="text" class="form-control" name="ds_book" id="ds_book"
                                           value="{{ $ds_book }}" placeholder="D/S Booking No">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="ds_no" id="ds_no"
                                           value="{{ $ds_no }}" placeholder="D/S No">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    @if($ds_book || $ds_no)
                                        <button type="button" class="btn btn-success" onclick="getReport()"><i
                                                    class="fa fa-print"></i> Print
                                        </button>
                                    @endif
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
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                           aria-describedby="example2_info">
                        <thead>
                        <tr role="row" class="bg-primary">
                            <th>No.</th>
                            <th>Travel Date</th>
                            <th>Agent</th>
                            <th>Ticket No</th>
                            <th>Voucher No</th>
                            <th>DS Book</th>
                            <th>DS No</th>
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
                            @if(session('mb_type')==1)
                                <th>Edit</th>
                            @endif
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
                                <td>{{ $k+1 }}</td>
                                <td>{{ $row->travel_date }}</td>
                                <td>{{ $row->agent->ag_name }}</td>
                                <td>{{ $row->ticket_no }}</td>
                                <td>{{ $row->voucher_no }}</td>
                                <td>{{ str_pad($row->dailySale->ds_book, 4, "0", STR_PAD_LEFT) }}</td>
                                <td>{{ str_pad($row->dailySale->ds_no, 6, "0", STR_PAD_LEFT) }}</td>
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
                                @if(session('mb_type')==1)
                                    <td>
                                        <a href="{{ url('booking/'.$row->category->con_folder.'/'.$row->order_id) }}">
                                            <button type="button" class="btn btn-sm btn-primary">Edit</button>
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

    <form role="form" id="getReport" action="{{ url('daily/credit/report') }}" method="post" target="_blank">
        {{ csrf_field() }}
        <input type="hidden" name="type_id" id="type_id" value="2">
        <input type="hidden" name="type_name" id="type_name" value="Credit">
        <input type="hidden" name="cat_id" id="cat_id" value="{{ $cat_id }}">
        <input type="hidden" name="ag_id" id="ag_id" value="{{ $ag_id }}">
        <input type="hidden" name="ds_book" id="ds_book" value="{{ $ds_book }}">
        <input type="hidden" name="ds_no" id="ds_no" value="{{ $ds_no }}">
    </form>
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

        function getReport() {
            $('#getReport').submit();
        }
    </script>
@stop