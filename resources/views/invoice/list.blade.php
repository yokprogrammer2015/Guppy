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
                <form role="form" action="{{ url('invoice/list') }}" method="post">
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
                                           value="{{ $inv_no }}" placeholder="Invoice">
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
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Agent</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>PDF</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice as $k => $row)
                            @php
                                $amount = $invoiceDetail->getAmount($row->inv_id);
                            @endphp
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $row->inv_no }}</td>
                                <td>{{ $row->inv_date }}</td>
                                <td>{{ $row->agent->ag_name }}</td>
                                <td>{{ number_format($amount) }}</td>
                                <td>
                                    <label class="{{ $row->badge($row->invoiceDetail->inv_type) }}">{{ $row->invoiceDetail->inv_type }}</label>
                                </td>
                                <td>
                                    <a href="{{ asset(env('INVOICE_PATH').$row->inv_no.'.pdf') }}" target="_blank">
                                        <button type="button" class="btn btn-sm btn-default">
                                            <i class="fa fa-file-pdf-o"></i> Invoice
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('invoice/sendMail/'.$row->inv_id) }}">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            <i class="fa fa-envelope-o"></i> Send Mail
                                        </button>
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