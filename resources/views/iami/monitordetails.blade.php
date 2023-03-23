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
        <li><a href="{{ $monitor }}">{{ $number->order_number }}</a></li>
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
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover" style="width: 100%;">
                <thead>
                  <tr>
                    <th class="head-table">No</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Progress</th>
                    <th class="head-table">Percent</th>
                    <th class="head-table">Status</th>
                    <th class="head-table">Print Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;?>
                    @foreach ($details as $row)
                      <tr>
                        <td class="" style="text-align: center;">{{ $no }}</td>
                        {{-- <td class=""><a href="{{ route('iami.monitor') }}/{{ $row->id }}">{{ $row->purchase_order_number }}</a></td> --}}
                        <td class=""><a href="{{ route('iami.list', $row->id) }}">{{ $row->order_number }}</a></td>
                        <td class="" style="text-align: center;">
                          <div class="progress progress-md">
                              <div class="progress-bar @if(number_format((float)(( $row->total_complete) * 100) / $row->total_order, 2, '.', ',') == 100) progress-bar-success @elseif(number_format((float)(( $row->total_complete) * 100) / $row->total_order, 2, '.', ',') > 0) progress-bar-warning @else progress-bar-danger @endif" style="width: {{ number_format((float)(( $row->total_complete) * 100) / $row->total_order, 2, '.', ',') }}%"></div>
                          </div>
                      </td>
                      <td class="" style="text-align: center;"><span class="badge @if(number_format((float)(( $row->total_complete) * 100) / $row->total_order, 2, '.', ',') == 100) bg-green @elseif(number_format((float)(( $row->total_complete) * 100) / $row->total_order, 2, '.', ',') > 0) bg-yellow @else bg-red @endif">{{ number_format((float)(( $row->total_complete) * 100) / $row->total_order, 2, '.', ',') }}</span></td>
                        <td class="" style="text-align: center;">
                            @if($row->progress == 'open')
                                <span class="label label-success" style="font-size: 14px;">Open</span>
                            @elseif($row->progress == 'progress')
                                <span class="label label-warning" style="font-size: 14px;">Progress</span>
                            @elseif($row->progress == 'complete')
                                <span class="label label-danger" style="font-size: 14px;">Close</span>
                            @else
                                <span class="label label-danger" style="font-size: 14px;">Ada kesalahan</span>
                            @endif
                        </td>
                        <td class="" style="text-align: center;">
                            @if($row->status == 'open')
                                <a href="{{ route('iami.sendorder') }}/{{ $row->id }}"><span class="label label-default" style="font-size: 14px;">Not Printed</span></a>
                            @elseif($row->status == 'progress')
                                <a href="{{ route('iami.sendorder') }}/{{ $row->id }}"><span class="label label-warning" style="font-size: 14px;">Partially Printed</span></a>
                            @elseif($row->status == 'send')
                                <span class="label label-success" style="font-size: 14px;">Printed</span>
                            @else
                                <span class="label label-danger" style="font-size: 14px;">Error Occured</span>
                            @endif
                        </td>
                      </tr>   
                      <?php $no = $no + 1; ?>                  
                    @endforeach
                  
                </tbody>
                <tfoot>
                  <tr>
                    <th class="head-table">No</th>
                    <th class="head-table">Order Number</th>
                    <th class="head-table">Progress</th>
                    <th class="head-table">Percent</th>
                    <th class="head-table">Status</th>
                    <th class="head-table">Print Status</th>
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
    "autoWidth": true
  } );
</script>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush
