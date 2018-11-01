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
                                        <label>Travel Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" name="travel_date" id="travel_date"
                                                   placeholder="mm/dd/yyyy" value="{{ $travel_date }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Daily Sale No</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="" id="" readonly
                                                   placeholder="D/S No">
                                            <span class="input-group-btn">
                                                   <button type="submit" class="btn btn-primary">Search</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href="{{ url('booking/train/daily') }}">
                                            <button type="button" class="btn btn-success">
                                                <i class="fa fa-plus"></i> Add
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form role="form" action="" method="post">
                    {{ csrf_field() }}
                    <div class="box-footer">
                        <table id="example2" class="table table-bordered table-hover" role="grid">
                            <thead>
                            <tr role="row" class="bg-primary">
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
                            <tr role="row" class="odd">
                                <td>Gecko</td>
                                <td>Firefox 1.0</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td>1.7</td>
                                <td>A</td>
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
                            </tr>
                            <tr role="row" class="even">
                                <td>Gecko</td>
                                <td>Firefox 1.0</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td>1.7</td>
                                <td>A</td>
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
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="16" class="text-right">
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
            $('#travel_date').datepicker({
                autoclose: true
            })
        });
    </script>
@stop