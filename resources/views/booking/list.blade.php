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
                <form role="form" action="{{ url('booking/list') }}" method="post">
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
                                <div class="col-md-3">
                                    <select class="form-control" name="ag_id" id="ag_id">
                                        <option value=""> -- Select --</option>
                                        @foreach($agent as $row)
                                            <option value="{{ $row->ag_id }}" @if($row->ag_id==$ag_id){{ 'selected' }}@endif>{{ $row->ag_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="ticket_no" id="ticket_no"
                                           value="{{ $ticket_no }}" placeholder="Ticket No">
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
                            <th>PDF</th>
                            <th>Cancel</th>
                            <th>Edit</th>
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
                                <td>
                                    <a href="{{ asset(env('TICKET_PATH').$row->order_id.'.pdf') }}" target="_blank">
                                        <button type="button" class="btn btn-sm btn-default">
                                            <i class="fa fa-file-pdf-o"></i> Ticket
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('booking/remove/'.$row->order_id) }}"
                                       onclick="return confirm('Are you sure you want to cancel this item?');">
                                        <button type="button" class="btn btn-sm btn-danger">Cancel</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('booking/'.$row->category->con_folder.'/'.$row->order_id) }}">
                                        <button type="button" class="btn btn-sm btn-primary">Edit</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
        })
    </script>
@stop