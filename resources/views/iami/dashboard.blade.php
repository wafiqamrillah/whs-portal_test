@extends('layouts.app_new')

@push('stylesheet')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush

@section('content')
    <section class="content-header">
      <h1>
        TMMIN
        <small>Order and Barcode Scan Activity</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/hometmmin">Dashboard TMMIN</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
          <div class="col-md-12">
              <div class="box box-solid">
                  <div class="box-body">
                      <table class="table table-bordered" style="width: 100%; text-align: center; font-size: 14px;">
                          <tr>
                              <td style="font-weight: bold; width: 20%; vertical-align: middle;">DEPARTURE DATE</td>
                              <td style="width: 20%; vertical-align: middle;"><input type="date" name="date" id="date" class="form-control" value="{{$data->del_date}}" style="width: 100%; font-size: 22px;" onchange="getData();"></td>
                              <td style="font-weight: bold; width: 20%; vertical-align: middle;">TIME</td>
                              <td id="time" style="width: 20%; vertical-align: middle; font-size: 22px"></td>
                              <td style="width: 15%; vertical-align: middle;"><button type="button" class="btn btn-primary" onclick="getData();" title="Reload data"><i class="fa fa-refresh"></i></button></td>
                          </tr>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daily Recap Report <small id="load_history">Data loaded on {{ date("Y/m/d H:i:s") }}</small></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row" hidden>
                    <div class="col-md-12">
                        <p class="text-center">
                            <strong>
                                <?php
                                  $bb = 1;
                                  $total_array = count($data->chart_results);
                                ?>
                                @if ($total_array > 0)
                                  @foreach($data->chart_results as $chart)
                                    @if ($total_array > 1)
                                        @if ($bb == $total_array)
                                          {{ $chart->days }}
                                        @else
                                          {{ $chart->days.' - ' }}
                                        @endif
                                    @else
                                        {{ $chart->days }}
                                    @endif
                                    @php $bb++; @endphp
                                  @endforeach
                                @else
                                  No data
                                @endif
                            </strong>
                        </p>
                        <p class="text-center">
                            <img src="../../dist/img/red_box.jpg" class="img-circle" alt="User Image"> : Order | 
                            <img src="../../dist/img/blue_box.jpg" class="img-circle" alt="User Image"> : Delivery
                        </p>
                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" style="height: 200px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                  <div class="row">
                    {{-- <div class="col-md-{{$col_size}} col-sm-{{$col_size}} col-xs-12"> --}}
                    <div class="col-lg-12 col-md-12 hidden-sm hidden-xs">
                      <div>
                        <table class="table table-bordered table-hover" style="width: 100%; font-size: 16px;">
                          <thead>
                            <tr id="table_head-lg">
                              @php
                                $count = count($data->cycle_results);
                                $col = 1;
                                $limit = 10;
                                if ($count > $limit) {
                                  $col = 2;
                                }
                              @endphp
                              @for($i = 0; $i < $col; $i++)
                                <th style="vertical-align: middle; text-align: center; width: 5%;">Lane No.</th>
                                <th style="vertical-align: middle; text-align: center; width: 12%;">Departure Time</th>
                                <th style="vertical-align: middle; text-align: center;">Kanban</th>
                                <th style="vertical-align: middle; text-align: center;">Percentage</th>
                                <th style="vertical-align: middle; text-align: center;">Status</th>
                              @endfor
                            </tr>
                          </thead>
                          <tbody id="cycle_data-lg" class="cycle_data">
                            @if (count($data->cycle_results) > 0)
                              @if ($col != 2)
                                @foreach($data->cycle_results as $cycle_results => $cycle)
                                  <tr>
                                    <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->cycle }}</td>
                                    <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->del_time }}</td>
                                    <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->kanban }}</td>
                                    <td>
                                      <div class="progress-group">
                                        <span class="progress-text"><b>{{ $cycle->complete_file }}</b>/{{ $cycle->total_file }}</span>
                                        <span class="progress-number"><b>{{ $cycle->percent }}%</b></span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-aqua" style="width: {{ $cycle->percent }}%"></div>
                                        </div>
                                      </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                      @if ($cycle->percent == 0)
                                        <span class="label label-success" style="font-size: 16px">Open</span>
                                      @elseif ($cycle->percent >= 100)
                                        <span class="label label-danger" style="font-size: 16px">Close</span>
                                      @else
                                        <span class="label label-warning" style="font-size: 16px">Progress</span>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              @else
                                @for($a = 0; $a < ($count/2); $a++)
                                  <tr>
                                    @php $cycle = $data->cycle_results[$a] @endphp
                                    <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->cycle }}</td>
                                    <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->del_time }}</td>
                                    <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->kanban }}</td>
                                    <td>
                                      <div class="progress-group">
                                        <span class="progress-text"><b>{{ $cycle->complete_file }}</b>/{{ $cycle->total_file }}</span>
                                        <span class="progress-number"><b>{{ $cycle->percent }}%</b></span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-aqua" style="width: {{ $cycle->percent }}%"></div>
                                        </div>
                                      </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                      @if ($cycle->percent == 0)
                                        <span class="label label-success" style="font-size: 16px">Open</span>
                                      @elseif ($cycle->percent >= 100)
                                        <span class="label label-danger" style="font-size: 16px">Close</span>
                                      @else
                                        <span class="label label-warning" style="font-size: 16px">Progress</span>
                                      @endif
                                    </td>
                                    @if (($a+($count/2)) > ($count - 1))
                                      <td colspan="5" style="text-align: center; font-size: 16px"></td>
                                    @else
                                      @php $cycle = $data->cycle_results[($a+round($count/2))] @endphp
                                      <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->cycle }}</td>
                                      <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->del_time }}</td>
                                      <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->kanban }}</td>
                                      <td>
                                        <div class="progress-group">
                                          <span class="progress-text"><b>{{ $cycle->complete_file }}</b>/{{ $cycle->total_file }}</span>
                                          <span class="progress-number"><b>{{ $cycle->percent }}%</b></span>
                                          <div class="progress sm">
                                              <div class="progress-bar progress-bar-aqua" style="width: {{ $cycle->percent }}%"></div>
                                          </div>
                                        </div>
                                      </td>
                                      <td style="text-align: center; vertical-align: middle;">
                                        @if ($cycle->percent == 0)
                                          <span class="label label-success" style="font-size: 16px">Open</span>
                                        @elseif ($cycle->percent >= 100)
                                          <span class="label label-danger" style="font-size: 16px">Close</span>
                                        @else
                                          <span class="label label-warning" style="font-size: 16px">Progress</span>
                                        @endif
                                      </td>
                                    @endif
                                  </tr>
                                @endfor
                              @endif
                            @else
                              <tr>
                                <td colspan="5" style="text-align: center; font-size: 16px">Data kosong.</td>
                              </tr>
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                      <div>
                        <table class="table table-bordered table-hover" style="width: 100%; font-size: 16px;">
                          <thead>
                            <tr>
                              <th style="vertical-align: middle; text-align: center; width: 5%;">Lane No.</th>
                              <th style="vertical-align: middle; text-align: center; width: 15%;">Departure Time</th>
                              <th style="vertical-align: middle; text-align: center;">Kanban</th>
                              <th style="vertical-align: middle; text-align: center;">Percentage</th>
                              <th style="vertical-align: middle; text-align: center;">Status</th>
                            </tr>
                          </thead>
                          <tbody id="cycle_data-sm" class="cycle_data">
                            @if (count($data->cycle_results) > 0)
                              @foreach($data->cycle_results as $cycle_results => $cycle)
                                <tr>
                                  <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->cycle }}</td>
                                  <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->del_time }}</td>
                                  <td style="text-align: center; font-size: 22px; vertical-align: middle;">{{ $cycle->kanban }}</td>
                                  <td>
                                    <div class="progress-group">
                                      <span class="progress-text"><b>{{ $cycle->complete_file }}</b>/{{ $cycle->total_file }}</span>
                                      <span class="progress-number"><b>{{ $cycle->percent }}%</b></span>
                                      <div class="progress sm">
                                          <div class="progress-bar progress-bar-aqua" style="width: {{ $cycle->percent }}%"></div>
                                      </div>
                                    </div>
                                  </td>
                                  <td style="text-align: center; vertical-align: middle;">
                                    @if ($cycle->percent == 0)
                                      <span class="label label-success" style="font-size: 16px">Open</span>
                                    @elseif ($cycle->percent >= 100)
                                      <span class="label label-danger" style="font-size: 16px">Close</span>
                                    @else
                                      <span class="label label-warning" style="font-size: 16px">Progress</span>
                                    @endif
                                  </td>
                                </tr>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="5" style="text-align: center; font-size: 16px">Data kosong.</td>
                              </tr>
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <table class="table table-bordered">
                        <tbody id="total_data">
                          <tr>
                            <td style="font-size: 22px; text-align: center; font-weight: bold; vertical-align: middle;">Total</td>
                            <td style="font-size: 22px; text-align: center; font-weight: bold; vertical-align: middle;">{{ $data->total_cycle->kanban }}</td>
                            <td>
                              <div class="progress-group">
                                <span class="progress-text"><b>{{ $data->total_cycle->complete_file }}</b>/{{ $data->total_cycle->total_file }}</span>
                                <span class="progress-number"><b>{{ $data->total_cycle->percent }}%</b></span>
                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua" style="width: {{ $data->total_cycle->percent }}%"></div>
                                </div>
                              </div>
                            </td>
                            <td style="text-align: center; vertical-align: middle; width: 21%">
                                @if ($data->total_cycle->percent == 0)
                                    <span class="label label-danger" style="font-size: 16px">Incompleted</span>
                                @elseif ($data->total_cycle->percent >= 100)
                                    <span class="label label-success" style="font-size: 16px">Completed</span>
                                @else
                                    <span class="label label-warning" style="font-size: 16px">Progress</span>
                                @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./box-body -->
                <!-- /.box-footer -->
                <div class="overlay" hidden>
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
@endsection

@push('scripts')
  <!-- Sparkline -->
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>-->
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
<script>
  $(document).ready(function(){
    startTime();
  });
  function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    $('#time').html(h + ":" + m + ":" + s);
    var t = setTimeout(startTime, 500);
  }
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }
</script>
<script>
  function getData() {
    var date = $('#date').val();
    var url = '{{ route("tmmin.dashboard", [":load", ":date"]) }}';
    url     = url.replace(':load', 'refresh').replace(':date', date);
    $.ajax({
      url     : url,
      type    : 'GET',
      dataType: "json",
      beforeSend: function(e){
        $('div.overlay').show();
      },
      success : function(data) {
	      var count = (data.results.cycle_results).length;
        var col = 1;
        var limit = {{$limit}};
        if (count > limit) {
          col = 2;
        }
        $('#table_head-lg').html('');
        for(var i = 0; i < col; i++){
          $('#table_head-lg').append(
            '<th style="vertical-align: middle; text-align: center; width: 5%;">Lane No.</th>'+
            '<th style="vertical-align: middle; text-align: center; width: 12%;">Departure Time</th>'+
            '<th style="vertical-align: middle; text-align: center;">Kanban</th>'+
            '<th style="vertical-align: middle; text-align: center;">Percentage</th>'+
            '<th style="vertical-align: middle; text-align: center;">Status</th>'
          );
        }
        
        if ((data.results.cycle_results).length > 0){
          if (col != 2){
            $('#cycle_data-lg').html('');
            $.each(data.results.cycle_results, function(key, value){
              var status = '';
              if (value.percent == 0) {
                status = '<span class="label label-success" style="font-size: 16px">Open</span>';
              } else if (value.percent >= 100) {
                status = '<span class="label label-danger" style="font-size: 16px">Close</span>';
              } else {
                status = '<span class="label label-warning" style="font-size: 16px">Progress</span>';
              }
              $('#cycle_data-lg').append(
                '<tr>'+
                  '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+value.cycle+'</td>'+
                  '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+value.del_time+'</td>'+
                  '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+value.kanban+'</td>'+
                  '<td>'+
                    '<div class="progress-group">'+
                      '<span class="progress-text"><b>'+value.complete_file+'</b>/'+value.total_file+'</span>'+
                      '<span class="progress-number"><b>'+value.percent+'%</b></span>'+
                      '<div class="progress sm">'+
                          '<div class="progress-bar progress-bar-aqua" style="width: '+value.percent+'%"></div>'+
                      '</div>'+
                    '</div>'+
                  '</td>'+
                  '<td style="text-align: center; vertical-align: middle;">'+status+'</td>'+
                '</tr>'+
              '');
            });
          }else{
            $('#cycle_data-lg').html('');
            for(var a = 0; a < (count/2); a++){
              var cycle_col1  = data.results.cycle_results[a];
              var status_col1 = '';
              if (cycle_col1.percent == 0) {
                status_col1 = '<span class="label label-success" style="font-size: 16px">Open</span>';
              } else if (cycle_col1.percent >= 100) {
                status_col1 = '<span class="label label-danger" style="font-size: 16px">Close</span>';
              } else {
                status_col1 = '<span class="label label-warning" style="font-size: 16px">Progress</span>';
              }
              var col1        =
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+cycle_col1.cycle+'</td>'+
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+cycle_col1.del_time+'</td>'+
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+cycle_col1.kanban+'</td>'+
                '<td>'+
                  '<div class="progress-group">'+
                    '<span class="progress-text"><b>'+cycle_col1.complete_file+'</b>/'+cycle_col1.total_file+'</span>'+
                    '<span class="progress-number"><b>'+cycle_col1.percent+'%</b></span>'+
                    '<div class="progress sm">'+
                        '<div class="progress-bar progress-bar-aqua" style="width: '+cycle_col1.percent+'%"></div>'+
                    '</div>'+
                  '</div>'+
                '</td>'+
                '<td style="text-align: center; vertical-align: middle;">'+status_col1+'</td>';
              
              if ((a+(count/2)) > (count-1)){
                var col2        = '<td colspan="5" style="text-align: center; font-size: 16px"></td>';
              }else{
                var cycle_col2  = data.results.cycle_results[(a+Math.round(count/2))];
                var status_col2 = '';
                if (cycle_col2.percent == 0) {
                  status_col2 = '<span class="label label-success" style="font-size: 16px">Open</span>';
                } else if (cycle_col2.percent >= 100) {
                  status_col2 = '<span class="label label-danger" style="font-size: 16px">Close</span>';
                } else {
                  status_col2 = '<span class="label label-warning" style="font-size: 16px">Progress</span>';
                }
                var col2        =
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+cycle_col2.cycle+'</td>'+
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+cycle_col2.del_time+'</td>'+
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+cycle_col2.kanban+'</td>'+
                '<td>'+
                  '<div class="progress-group">'+
                    '<span class="progress-text"><b>'+cycle_col2.complete_file+'</b>/'+cycle_col2.total_file+'</span>'+
                    '<span class="progress-number"><b>'+cycle_col2.percent+'%</b></span>'+
                    '<div class="progress sm">'+
                        '<div class="progress-bar progress-bar-aqua" style="width: '+cycle_col2.percent+'%"></div>'+
                    '</div>'+
                  '</div>'+
                '</td>'+
                '<td style="text-align: center; vertical-align: middle;">'+status_col2+'</td>';
              }
              $('#cycle_data-lg').append('<tr>'+col1+col2+'</tr>');
            }                 
          }
          $('#cycle_data-sm').html('');
          $.each(data.results.cycle_results, function(key, value){
            var status = '';
            if (value.percent == 0) {
              status = '<span class="label label-success" style="font-size: 16px">Open</span>';
            } else if (value.percent >= 100) {
              status = '<span class="label label-danger" style="font-size: 16px">Close</span>';
            } else {
              status = '<span class="label label-warning" style="font-size: 16px">Progress</span>';
            }
            $('#cycle_data-sm').append(
              '<tr>'+
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+value.cycle+'</td>'+
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+value.del_time+'</td>'+
                '<td style="text-align: center; font-size: 22px; vertical-align: middle;">'+value.kanban+'</td>'+
                '<td>'+
                  '<div class="progress-group">'+
                    '<span class="progress-text"><b>'+value.complete_file+'</b>/'+value.total_file+'</span>'+
                    '<span class="progress-number"><b>'+value.percent+'%</b></span>'+
                    '<div class="progress sm">'+
                        '<div class="progress-bar progress-bar-aqua" style="width: '+value.percent+'%"></div>'+
                    '</div>'+
                  '</div>'+
                '</td>'+
                '<td style="text-align: center; vertical-align: middle;">'+status+'</td>'+
              '</tr>'+
            '');
          });
        }
        else{
          $('.cycle_data').html(
            '<tr>'+
              '<td colspan="5" style="text-align: center; font-size: 14px">Data kosong.</td>'+
            '</tr>');
        }
        var total = data.results.total_cycle;
        var status = '';
        if (total.percent == 0) {
          status = '<span class="label label-danger" style="font-size: 16px">Incompleted</span>';
        } else if (total.percent >= 100) {
          status = '<span class="label label-success" style="font-size: 16px">Completed</span>';
        } else {
          status = '<span class="label label-warning" style="font-size: 16px">Progress</span>';
        }
        $('#total_data').html(
          '<tr>'+
            '<td style="font-size: 22px; text-align: center; font-weight: bold; vertical-align: middle;">Total</td>'+
            '<td style="font-size: 22px; text-align: center; font-weight: bold; vertical-align: middle;">'+total.kanban+'</td>'+
            '<td>'+
              '<div class="progress-group">'+
                '<span class="progress-text"><b>'+total.complete_file+'</b>/'+total.total_file+'</span>'+
                '<span class="progress-number"><b>'+total.percent+'%</b></span>'+
                '<div class="progress sm">'+
                    '<div class="progress-bar progress-bar-aqua" style="width: '+total.percent+'%"></div>'+
                '</div>'+
              '</div>'+
            '</td>'+
            '<td style="text-align: center; vertical-align: middle; width: 21%">'+status+'</td>'+
          '</tr>'
        );
        var date_now = date.split('-')[0]+'/'+date.split('-')[1]+'/'+date.split('-')[2]+' ';
        var time = $('#time').text();
        $('#load_history').html('Data reloaded on '+date_now+' '+time);
      },
      complete : function(){
        $('div.overlay').hide();
      },
      error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
      }   
    });
  }
</script>
<script>
  $(function () {
    'use strict';
    <?php
      $ii = 500;
    ?>
    /* ChartJS
    * -------
    * Here we will create a few charts using ChartJS
    */

    // -----------------------
    // - MONTHLY SALES CHART -
    // -----------------------

    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    // This will get the first returned node in the jQuery collection.
    var salesChart       = new Chart(salesChartCanvas);

    var salesChartData = {
      // labels  : ['0','1', '2', '3', '4', '5', '6', '7',],
      labels  : ['0',
        @foreach($data->chart_results as $chart)
          '{{ $chart->days }}',
        @endforeach
         ],
      datasets: [
        {
            label               : 'Order',
            fillColor           : 'rgb(255, 0, 0)',
            strokeColor         : 'rgb(255, 0, 0)',
            pointColor          : 'rgb(255, 0, 0)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgb(255, 0, 0)',
            // data                : [0, {{ $ii }}, {{ $ii + 300 }}, 1060, 1063, 1062, 1065, 1060,]
            data                : [0, 
            @foreach($data->chart_results as $chart)
              {{ $chart->total_label.', ' }}
            @endforeach
            ]
        },
        {
            label               : 'Delivery',
            fillColor           : 'rgba(60,141,188,0.9)',
            strokeColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            // data                : [0, 1064, 1059, 1060, 1061, 1060, 1065, 1058,]
            data                : [0, 
            @foreach($data->chart_results as $chart)
              {{ $chart->total_scan.', ' }}
            @endforeach
            ]
        }
      ]
    };

    var salesChartOptions = {
      // Boolean - If we should show the scale at all
      showScale               : true,
      // Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      // String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      // Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      // Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      // Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      // Boolean - Whether the line is curved between points
      bezierCurve             : true,
      // Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      // Boolean - Whether to show a dot for each point
      pointDot                : false,
      // Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      // Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      // Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      // Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      // Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      // String - A legend template
      legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      // Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    };

    // Create the line chart
    salesChart.Line(salesChartData, salesChartOptions);
  });
  </script>
  @endpush
