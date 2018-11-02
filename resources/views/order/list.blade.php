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
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="ag_id" id="ag_id">
                                        <option value=""> -- Select --</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="ticket_no" id="ticket_no"
                                           value="" placeholder="Ticket No">
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
                        <tr role="row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="" target="_blank">
                                    <button type="button" class="btn btn-sm btn-default">
                                        <i class="fa fa-file-pdf-o"></i> Ticket
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href=""
                                   onclick="return confirm('Are you sure you want to cancel this item?');">
                                    <button type="button" class="btn btn-sm btn-danger">Cancel</button>
                                </a>
                            </td>
                            <td>
                                <a href="">
                                    <button type="button" class="btn btn-sm btn-primary">Edit</button>
                                </a>
                            </td>
                        </tr>
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