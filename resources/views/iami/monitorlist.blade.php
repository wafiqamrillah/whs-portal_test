@extends('layouts.app_new')

@push('stylesheet')
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <style>
    .head-table {
     font-size: 80%; 
    }
    td{
      font-size: 90%;
    }
  </style>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('content')
    <section class="content-header">
      <h1>
        IAMI
        <small>Monitor Delivery</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('iami.monitor') }}/">Monitor delivery</a></li>
        <li><a href="{{ route('iami.monitor', $number->order_number) }}">{{ $number->order_number }}</a></li>
        <li><a href="{{ $monitor }}">{{$monitor }}</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Label Details > <strong>{{ $number->order_number }}</strong></h3>
              <a target="_blank" href="{{route('iami.report', $monitor)}}" class="pull-right btn btn-primary btn-sm">PDF</a>
              <a target="_blank" href="{{route('iami.report.excel', $monitor)}}" class="pull-right btn btn-primary btn-sm">Excel</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover nowrap">
                <thead>
                  <tr>
                    <th class="head-table">No</th>
                    <th class="head-table">Part Number</th>
                    <th class="head-table">Part Name</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Purchase Order Number</th>
                    <th class="head-table">Kanban Number</th>
                    <th class="head-table">Kanban Scan Time</th>
                    <th class="head-table">MSI Label Number</th>
                    <th class="head-table">MSI Label Scan Time</th>
                    <th class="head-table">User</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $no = 1;?>
                    @foreach ($detail_label as $detail_label)
                      <tr class="@if($detail_label->order->purchase_order_number == '' && $detail_label->msi_label_scan_at == '') bg-danger @elseif($detail_label->msi_label_scan_at == '') bg-warning @endif">
                        <td>{{ $no }}</td>
                        <td>{{ $detail_label->orderList->part_number }}</a></td>
                        <td>{{ $detail_label->orderList->part_name }}</a></td>
                        <td>{{ $detail_label->order->order_number }}</a></td>
                        <td>{{ $detail_label->order->purchase_order_number }}</a></td>
                        <td>{{ $detail_label->kanban_number }}</a></td>
                        <td>{{ $detail_label->kanban_scan_at }}</td>
                        <td>{{ $detail_label->msi_label_number }}</a></td>
                        <td>{{ $detail_label->msi_label_scan_at }}</td>
                        <td>{{ Auth::user()->nik }}</td>

                      </tr>   
                      <?php $no = $no + 1; ?>                  
                    @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th class="head-table">No</th>
                    <th class="head-table">Part Number</th>
                    <th class="head-table">Part Name</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Label Scan Time</th>
                    <th class="head-table">MSI Label Number</th>
                    <th class="head-table">MSI Label Scan Time</th>
                    <th class="head-table">User</th>
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
<script>
  $('#example1').dataTable( {
    "pageLength": 10,
    "scrollX": true,
    "autoWidth": true,
    "columnDefs": [
      { "targets": '_all', "className": "" }
    ],
  } );
  </script>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

