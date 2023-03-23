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
        TMMIN
        <small>Order List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('tmmin.index')}}/">Order list</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Order List</h3>
              <button class="pull-right btn btn-primary btn-sm" data-toggle="modal" data-target="#new-modal"><i class="fa fa-plus"></i> New Order</button>
	            <a class="pull-right btn btn-primary btn-sm" href="/download/master_upload_tmmin.xlsx">TMMIN Master Template</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th class="head-table">File Name</th>
                    <th class="head-table">Upload Time</th>
                    <th class="head-table">Upload By</th>
                    <th class="head-table">Progress</th>
                    <th class="head-table">Percent</th>
                    <th class="head-table">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $list)
                  <tr>
                    <td class="head-table"><a href="{{ route('tmmin.index') }}/{{ $list->file_name }}">{{ $list->file_name }}</a></td>
                    <td class="head-table">{{ $list->upload_time }}</td>
                    <td class="head-table">{{ $list->name }}</td>
                    <td class="head-table">
                      <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-danger" style="width: {{ number_format((float)(($list->totalall - $list->totalnull) * 100) / $list->totalall, 2, '.', ',') }}%"></div>
                      </div>
                    </td>
                    <td class="head-table">{{ number_format((float)(($list->totalall - $list->totalnull) * 100) / $list->totalall, 2, '.', ',') }}</td>
                    <td>
                      <button type="button" class="btn-delete btn btn-xs btn-danger" data-toggle='modal' data-target="#modal-delete" data-file="{{ $list->file_name }}"><i class="fa fa-trash"></i> Delete</button>
                    </td>
                  </tr>                     
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th class="head-table">File Name</th>
                    <th class="head-table">Upload Time</th>
                    <th class="head-table">Upload By</th>
                    <th class="head-table">Progress</th>
                    <th class="head-table">Percent</th>
                    <th class="head-table">Action</th>
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
      <!-- Modals -->
        <div class="modal fade" id="new-modal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form method="post" action="{{ route('tmmin.createOrder') }}" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Order</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-xs-12">
                    <small>Pilih salah satu mode pengisian :</small>
                  </div>
                  <div class="col-xs-2">
                    <div class="radio">
                      <label>
                        <input type="radio" name="choice" value="form" checked>
                        Form
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-2">
                    <div class="radio">
                      <label>
                        <input type="radio" name="choice" value="file">
                        Import
                      </label>
                    </div>
                  </div>
                </div><br>
                <div id="file_opt" class="row" hidden>
                  <div class="col-xs-12">
                    <input type="file" id="file" name="file" class="form-control">
                    <small>File yang diunggah harus file Excel yang copy tanpa ada password dari File TMMIN Master Template Original.</small>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- endModals -->
      <!-- Modals -->
        <div class="modal fade" id="input_part-modal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Input Part</h4>
              </div>
              <div class="modal-body">
                <table id="part_list" class="table table-striped table-hover responsive" style="width: 100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Part Number</th>
                      <th>Part Description</th>
                      <th>Supplier Data</th>
                      <th>Box Type</th>
                      <th style="text-align: center">Qty/Box</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($product as $products)
                      <tr>
                        <td><input type="checkbox" name="partno[]" value="{{ $products['id'] }}"></td>
                        <td>{{ $products['partno'] }}</td>
                        <td>{{ $products['partdesc'] }}</td>
                        <td>{{ $products['jobno'] }}</td>
                        <td>{{ $products['box_type'] }}</td>
                        <td style="text-align: center;">{{ $products['filling_qty'] }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn-add">Add</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- endModals -->
      <!-- Modal Delete-->
        <div class="modal fade" id="modal-delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Order</h4>
              </div>
              <div class="modal-body">
                <div class="alert alert-danger fade in" style="display: none;">
                  <a href="#" class="close" aria-label="close" onclick="$('.alert').hide()">&times;</a>
                  Tidak dapat dihapus, karena order sudah discan barcode!
                </div>
                Anda yakin ingin menghapus file <span id="data_delete" style="font-weight: bold;"></span> ?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="delete_btn" data-file="">Delete</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
        <!-- /.modal-dialog -->
        </div>
      <!-- endModal-->
      <!-- Modal Delete Confirmation-->
        <div class="modal fade" id="modal-delete-confirmation">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="delete_form" method="post" action="{{ route('tmmin.forcedelete.process') }}" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                  Mohon isi form berikut untuk menghapus data order <span id="data_delete_confirmation" style="font-weight: bold;"></span>
                  <div id="data_input"></div>
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label>* Dilakukan oleh : </label>
                      <input class="form-control" type="text" name="request_by" onkeyup="filltext();" placeholder="Nama Pemohon" value="{{ Auth::user()->name }}" readonly>                        
                    </div>
                    <div class="col-md-6">
                      <label>* Disetujui oleh : </label>
                      <input class="form-control" type="text" name="approved_by" onkeyup="filltext();" placeholder="Yang menyetujui">                       
                    </div>
                  </div>
                  <textarea class="form-control" name="reason" rows="4" form="delete_form" placeholder="* Alasan..." onkeyup="filltext();"></textarea>
                  <small style="font-weight: bold;">*) Semua form harus terisi.</small><br>
                  <small style="font-weight: bold;">Catatan:</small>
                  <small>Tindakan ini akan menghapus data order dan label. Data yang dihapus, tidak bisa dikembalikan.</small>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger" disabled="true" id="delete_confirmation_btn">Delete</button>
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
        <!-- /.modal-dialog -->
        </div>
      <!-- endModal-->
    </section>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/custom.dataTable.js') }}"></script>
<script>
  var part_list = [];
  $('#part_list').dataTable( {
    "order" : [[ 1, 'asc']],
    "columnDefs": [
      { "width": "10%", "orderable" : false, "targets": 0 },
      { "width": "25%", "targets": 1 },
      { "width": "30%", "targets": 2 },
      { "width": "15%", "targets": 3 },
      { "width": "15%", "targets": 4 }
    ],
  });

  $("#form_list").on("click", ".btn-remove", function() {
    $(this).closest('tr').remove();
  });

  $('#new-modal').on('click', 'input[type="radio"]', function(event){
    var option = $(this).val();
    switch(option){
      case "form":
        //#form_opt
          $("#form_opt").removeAttr('hidden');
          $("#form_opt").find('input[name="do_no"]').attr('required', true);
          $("#form_opt").find('input[name="order_no"]').attr('required', true);
          $("#form_opt").find('input[name="dep_date"]').attr('required', true);
          $("#form_opt").find('input[name="arr_date"]').attr('required', true);
          $("#form_opt").find('input[name="lane_no"]').attr('required', true);
          $("#form_opt").find('input[name="supplier_data[]"]').attr('required', true);
          $("#form_opt").find('input[name="uniq_no[]"]').attr('required', true);
          $("#form_opt").find('input[name="box_type[]"]').attr('required', true);
          $("#form_opt").find('input[name="order_qty[]"]').attr('required', true);
        //#file_opt
          $("#file_opt").attr('hidden', true);
      break;
      case "file":
        //#form_opt
          $("#form_opt").attr('hidden', true);
          $("#form_opt").find('input[name="do_no"]').removeAttr('required');
          $("#form_opt").find('input[name="order_no"]').removeAttr('required');
          $("#form_opt").find('input[name="dep_date"]').removeAttr('required');
          $("#form_opt").find('input[name="arr_date"]').removeAttr('required');
          $("#form_opt").find('input[name="lane_no"]').removeAttr('required');
          $("#form_opt").find('input[name="supplier_data[]"]').removeAttr('required');
          $("#form_opt").find('input[name="uniq_no[]"]').removeAttr('required');
          $("#form_opt").find('input[name="box_type[]"]').removeAttr('required');
          $("#form_opt").find('input[name="order_qty[]"]').removeAttr('required');
        //#file_opt
          $("#file_opt").removeAttr('hidden');
      break;
    }
  });

  $("#form_list").on('input', 'input[name="order_qty[]"]', function(e){
    var row = $(this).closest('tr');
    var qty_box = row.find('input[name="qty_box[]"]').val();
    var total_kanban = row.find('input[name="total_kanban[]"]').val();
    var order_qty = $(this).val();
    total_kanban = Math.ceil(order_qty/qty_box);
    row.find('input[name="total_kanban[]"]').val(total_kanban);
  });

  $("#part_list").on("click", "input[type='checkbox']", function(event){
    var $this = $(this);
    var row = $(this).closest("tr");
    var record = {'id':row.find('td:eq(0) input').val(),'part_number':row.find('td:eq(1)').text(),'part_desc':row.find('td:eq(2)').text(),'supplier_data':row.find('td:eq(3)').text(),'box_type':row.find('td:eq(4)').text(),'qty_box':row.find('td:eq(5)').text()}
    var isChecked = $this[0].checked;

    if (isChecked) {
      part_list.push(record);
    } else {
      part_list.filter(function(v,i){
        if(v.id === record.id){
          part_list.splice(i, 1);
        }
      });
    }
  });

  $('#btn-add').click(function(){
    $('#form_list').empty();
    $.each(part_list ,function(key,value){
      var supplier_data = '';
      var box_type = '';
      if (value['supplier_data']) {
        supplier_data = 'value="'+value['supplier_data']+'" readonly';
      }else{
        supplier_data = 'required';
      }
      if (value['box_type']) {
        box_type = 'value="'+value['box_type']+'" readonly';
      }else{
        box_type = 'required';
      }
      $('#form_list').append('<tr>'+
                                '<td style="width:50px; text-align: center;"><button type="button" class="btn-remove btn btn-xs btn-danger"><i class="fa fa-minus"></i></button></td>'+
                                '<td style="width: 15%;"><input class="form-control input-sm" type="text" name="part_num[]" value="'+value['part_number']+'" readonly></td>'+
                                '<td><input class="form-control input-sm" type="text" name="part_desc[]" value="'+value['part_desc']+'" readonly></td>'+
                                '<td style="width: 10%;"><input class="form-control input-sm" type="text" name="supplier_data[]" '+supplier_data+'></td>'+
                                '<td style="width: 10%;"><input class="form-control input-sm" type="text" name="uniq_no[]" required></td>'+
                                '<td style="width: 10%;"><input class="form-control input-sm" type="text" name="box_type[]" '+box_type+'></td>'+
                                '<td style="width: 10%;"><input class="form-control input-sm" type="number" style="text-align: right;" name="qty_box[]" value="'+value['qty_box']+'" readonly></td>'+
                                '<td style="width: 10%;"><input class="form-control input-sm" type="number" style="text-align: right;" name="total_kanban[]" value="0" readonly></td>'+
                                '<td style="width: 10%;"><input class="form-control input-sm" type="number" style="text-align: right;" name="order_qty[]" min="0" required></td>'+
                              '</tr>');
    });
  });

  $('.btn-delete').click(function(){
    var target = $(this).data('file');
    $("#data_delete").html(target);
    $('#data_input').html('');
    $("#data_input").html("<input type='hidden' name='orders[]' value='"+target+"'>");
    $('#delete_btn').data('file', target);
    $('.alert').hide();
  });

  $('#delete_btn').click(function(){
    var target = $(this).data('file');
    $.ajax({
          url     : '/ordertmmin/delete/'+target,
          type    : 'GET',
          dataType: "json",
          beforeSend: function(e){
            if(e && e.overrideMimeType){
              e.overrideMimeType('application/jsoncharset=UTF-8')
            }
          },
          success : function(data) {
            if (data.status == 'delete') {
              location.reload();
            }else if (data.status == 'confirmation') {
              $('#modal-delete').modal('hide');
              $('#data_delete_confirmation').html($(this).data('file'));
              $('#modal-delete-confirmation').modal('show');
              $('#modal-delete-confirmation form')[0].reset();
            }else{
              $('.alert').show();
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.responseText);
          }   
    });
  });
  function filltext(){
    var approved_by  = $("input[name=approved_by]").val().length;
    var reason       = $("textarea[name=reason]").val().length;
    var result       = approved_by * reason;
    if(result != 0){
      $('#delete_confirmation_btn').removeAttr('disabled');
    }else{
      $('#delete_confirmation_btn').attr('disabled', true);      
    }
  }
</script>
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
@endpush
