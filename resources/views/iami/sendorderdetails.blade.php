@extends('layouts.app_new')

@push('stylesheet')
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <style>
    .head-table {
     font-size: 80%; 
    }
    .red {
      color: red;
    }
  </style>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('content')
    <section class="content-header">
      <h1>
        IAMI
        <small>Send Order</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('iami.sendorder')}}/">Send order</a></li>
        <li><a href="{{route('iami.sendorder', $id)}}">{{ $number->order_number }}</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <form method="post" action="{{ route('iami.sendprocess', $id) }}" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" onsubmit="javascript: setTimeout(function(){location.reload();}, 1000);return true;">
          	{{ csrf_field() }}
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Order Details > {{ $number->order_number }}</h3>
              <button type="submit" class="btn-send btn btn-default pull-right" disabled>Send Order</button>
              {{-- <a href="" target="_blank" class="btn btn-success pull-right">Send All</a> --}}
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover" style="width: 100%;">
                <thead>
                  <tr>
                    <th class="head-table"></th>
                    <th class="head-table">No</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Purchase Order</th>
                    <th class="head-table">Order Date</th>
                    <th class="head-table">Order Time</th>
                    <th class="head-table">Status</th>
                    <th class="head-table">Kanban Scan Time</th>
                    <th class="head-table">Scanned By</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $no = 1;?>
                    @foreach ($detail_orders as $detail_order)
                      <tr>
                      	<td style="text-align: center; vertical-align: middle;">
                      		<label>
                      			<input type="checkbox" class="minimal" name="checkbox_order[]" value="{{$detail_order->order_number}}" @if($detail_order->status != 'open')
                      			checked disabled
                      			@endif>
                			    </label>
                      	</td>
                      	<td style="text-align: center; vertical-align: middle;">{{ $no }}</td>
                        <td style="vertical-align: middle;">{{ $detail_order->order_number   }}</td>
                        <td style="vertical-align: middle;">{{ $detail_order->purchase_order_number  }}</td>
                        <td style="vertical-align: middle;">{{ $detail_order->order_date }}</td>
                        <td style="vertical-align: middle;">{{ $detail_order->order_time }}</td>
                        <td style="text-align: center; vertical-align: middle;">
                          @if($detail_order->status != 'open')
                            <span class="label label-success">Sudah Print</span>
                          @else
                            <span class="label label-default">Belum Print</span>
                          @endif
                        </td>
                        <td style="vertical-align: middle;"></td>
                        <td style="vertical-align: middle;">{{ $detail_order->name }}</td>
                      </tr>   
                      <?php $no++; ?>                  
                    @endforeach
                  
                </tbody>
                <tfoot>
                  <tr>
                    <th class="head-table"></th>
                    <th class="head-table">No</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Purchase Order</th>
                    <th class="head-table">Order Date</th>
                    <th class="head-table">Order Time</th>
                    <th class="head-table">Status</th>
                    <th class="head-table">Kanban Scan Time</th>
                    <th class="head-table">Scanned By</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          </form>
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
    "order" : [[ 1, 'asc']],
    "columnDefs": [
      { "orderable" : false, "targets": 0 },
      { "targets": '_all', "className": "" }
    ],
  } );

  $("#example1").on("click", "input[type='checkbox']", function(event){
      var count = $('.minimal').filter(':checked').length;
      if(count > 0){
        $('.btn-send').removeAttr('disabled');
      }else{
        $('.btn-send').prop('disabled', 'disabled');
      }
  });
</script>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush
