@extends('layouts.app_new')

@push('stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <style>
        .head-table {
            font-size: 80%;
        }

        td {
            font-size: 90%;
        }
    </style>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset('css/myFile.min.css') }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('content')
    <section class="content-header">
        <h1>
            IAMI
            <small>Send Order</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            {{-- <li><a href="{{ route('iami.sendoderdetails') }}/">Send order</a></li> --}}
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Order List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="head-table">File Name</th>
                                    <th class="head-table">Status Print</th>
                                    <th class="head-table">Upload Time</th>
                                    <th class="head-table">Upload By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_orders as $list_order)
                                    <tr>
                                        <td style="vertical-align: middle"><a
                                                href="{{ route('iami.sendorder') }}/{{ $list_order->id }}">{{ $list_order->order_number }}</a>
                                        </td>
                                        <td style="text-align: left; vertical-align: middle;">
                                            @if ($list_order->status != 'open')
                                                <span class="label label-success">Sudah Print</span>
                                            @else
                                                <span class="label label-default">Belum Print</span>
                                            @endif
                                        </td>
                                        <td>{{ $list_order->order_date }}</td>
                                        <td>{{ $list_order->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="head-table">File Name</th>
                                    <th class="head-table">Status Print</th>
                                    <th class="head-table">Upload Date</th>
                                    <th class="head-table">Upload By</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@push('scripts')
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/custom.dataTable.js') }}"></script>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset('css/myFile.min.css') }}" rel="stylesheet">" rel="stylesheet">-->
@endpush
