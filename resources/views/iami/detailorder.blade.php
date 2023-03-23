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
        <small>Order List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('iami.order')}}/">Order list</a></li>
        <li><a href="{{route('iami.order', $source['id'])}}">{{ $number->order_number }}</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Order Details > {{ $number->order_number }}</h3>
            </div>
            <!-- Modal Exim-->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover nowrap">
                <thead>
                  <tr>
                    <th class="head-table">No</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Purchase Order</th>
                    <th class="head-table">Order Date</th>
                    <th class="head-table">Order Time</th>
                    <th class="head-table">Kanban Number</th>
                    <th class="head-table">Kanban Scan Time</th>
                    <th class="head-table">Scanned By</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;?>
                  @foreach ($details as $detail)
                    <tr>
                      <td style="vertical-align: middle">{{ $no }}</td>
                      <td style="vertical-align: middle">{{ $detail->order->order_number }}</td>
                      <td style="vertical-align: middle; text-align: center;">{{ $detail->order->purchase_order_number }}</td>
                      <td style="vertical-align: middle">{{ $detail->order->order_date }}</td>
                      <td style="vertical-align: middle">{{ $detail->order->order_time }}</td>
                      <td style="vertical-align: middle">{{ $detail->kanban_number }}</td>
                      <td style="vertical-align: middle; text-align: center;">{{ $detail->kanban_scan_at }}</td>
                      <td style="vertical-align: middle; text-align: center;">{{ $detail->kanban_scan_by }}</td>
                    </tr>
                    <?php $no = $no + 1;?>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th class="head-table">No</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Purchase Order</th>
                    <th class="head-table">Order Date</th>
                    <th class="head-table">Order Time</th>
                    <th class="head-table">Kanban Number</th>
                    <th class="head-table">Kanban Scan Time</th>
                    <th class="head-table">Scanned By</th>  
                  </tr>
                </tfoot>
              </table>
              <small>Uploaded by : {{ $source['name'] }} date: {{ $source['order_date'] }}</small>
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
    {{-- <!-- Example -->
      <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet"> --}}
@endpush