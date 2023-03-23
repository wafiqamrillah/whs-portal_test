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
            <small>Monitor Delivery</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('tmmin.monitor') }}/">Monitor delivery</a></li>
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
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="head-table">File Name</th>
                                    <th class="head-table">Progress</th>
                                    <th class="head-table">Percent</th>
                                    <th class="head-table">Upload Time</th>
                                    <th class="head-table">Upload By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_orders as $list_order)
                                    <tr>
                                        <td style="vertical-align: middle"><a
                                                href="{{ route('iami.monitor') }}/{{ $list_order->id }}">{{ $list_order->order_number }}</a>
                                        </td>
                                        {{-- <td style="vertical-align: middle; text-align: center;">
                                            {{ $list_order->created_by == Auth()->user()->id ? Auth()->user()->name : Auth()->user()->name }}
                                        </td> --}}
                                        <td style="vertical-align: middle; text-align: center;">
                                            <div
                                                class="progress progress-md @if (number_format(
                                                        (float) (($list_order->totalall - $list_order->totalnull) * 100) / $list_order->totalall,
                                                        2,
                                                        '.',
                                                        ',') != 100) active @endif">
                                                <div class="progress-bar @if (number_format(
                                                        (float) (($list_order->totalall - $list_order->totalnull) * 100) / $list_order->totalall,
                                                        2,
                                                        '.',
                                                        ',') == 100) progress-bar-success @elseif(number_format(
                                                        (float) (($list_order->totalall - $list_order->totalnull) * 100) / $list_order->totalall,
                                                        2,
                                                        '.',
                                                        ',') > 0) progress-bar-warning progress-bar-striped @else progress-bar-danger progress-bar-striped @endif"
                                                    style="width: {{ number_format((float) (($list_order->totalall - $list_order->totalnull) * 100) / $list_order->totalall, 2, '.', ',') }}%">
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;"><span
                                                class="badge @if (number_format(
                                                        (float) (($list_order->totalall - $list_order->totalnull) * 100) / $list_order->totalall,
                                                        2,
                                                        '.',
                                                        ',') == 100) bg-green @elseif(number_format(
                                                        (float) (($list_order->totalall - $list_order->totalnull) * 100) / $list_order->totalall,
                                                        2,
                                                        '.',
                                                        ',') > 0) bg-yellow @else bg-red @endif">{{ number_format((float) (($list_order->totalall - $list_order->totalnull) * 100) / $list_order->totalall, 2, '.', ',') }}</span>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                          {{ $list_order->created_at }}</td>
                                        <td style="vertical-align: middle">{{ $list_order->name }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="head-table">File Name</th>
                                    <th class="head-table">Progress</th>
                                    <th class="head-table">Percent</th>
                                    <th class="head-table">Upload Time</th>
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
