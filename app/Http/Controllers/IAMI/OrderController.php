<?php

namespace App\Http\Controllers\IAMI;

use App\Http\Controllers\Controller;
use App\Models\IAMI\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;
use DateTime;
use DB;
use Excel;
use App\Imports\ExcelImport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_error = Order::count();
  
        // Tanggal dan Waktu
        $get_date = new DateTime('-2 week'); //Data yang akan muncul diambil dari data yang disimpan dari parameter DateTime() sampai sekarang
        $get_date = $get_date->format('Y-m-d H:i:s');
        $date_now = new DateTime();
        $date_now = $date_now->format('Y-m-d H:i:s');
        
        // $list = Order::whereBetween('iami_orders.created_at', [$get_date, $date_now])
        //     ->join('users', 'users.id', '=', 'iami_orders.created_by')
        //     ->join('iami_labels', 'iami_labels.order_id', '=', 'iami_orders.id')
        //     ->join('iami_order_lists', 'iami_order_lists.order_id', '=', 'iami_orders.id')
        //     ->select('iami_orders.number', 'iami_labels.msi_label_scan_at', 'iami_orders.id', 'iami_orders.order_number', 'iami_orders.order_date', 'iami_orders.order_time', 'users.name', DB::raw('count(IF(iami_labels.msi_label_scan_at is NULL,1,NULL)) as totalnull'), DB::raw('count(iami_order_lists.total_kanban) as totalall'))
        //     ->orderBy('iami_orders.id', 'asc')
        //     ->groupBy('iami_orders.order_number')
        //     ->get();
        $list = collect([]);
  
        return view('iami.order', [
           'list' => $list,
           'data_error' => $data_error,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Permulaan DB Transaction
        return \DB::transaction(function () use ($request) {
  
           // Mendapatkan waktu sekarang
           $ldatetime = Carbon::now();
           
           if ($request->hasFile('file')) {
                // Mengambil lokasi file temporary upload
                $path = $request->file('file')->getRealPath();
                $file = $request->file('file');
    
                // Data di-group berdasarkan order_number
                $imports = (new ExcelImport)->toArray($file);

                // Import
                $imports = collect($imports[0]);

                // Header
                $header = $imports->splice(0, 1)->first();
              
                // Datas
                $datas = $imports->map(function($data) use($header) {
                    return collect($data)->mapWithKeys(function($d, $i) use($header) {
                        return [$header[$i] => $d];
                    });
                })->groupBy('order_number');
  
                // Jika data yang didapatkan tidak kosong, maka lanjut. Jika tidak, maka memunculkan pesan error
                if (!empty($datas) && $datas->count() > 0) {
                    if (!empty($datas)) {
                        // Setiap data order diproses masing-masing
                        foreach ($datas as $data) {
                        // Mengambil data pertama
                        $first_data = $data->first();
    
                        $ldatetime = Carbon::now();
                        $lday = $ldatetime->format('d');
                        $lmonth = $ldatetime->format('m');
                        $lyear = $ldatetime->format('Y');
                        $lhour = $ldatetime->format('H');
                        $lminute = $ldatetime->format('i');
                        $lsecond = $ldatetime->format('s');
    
                        // Variables
                        $order_number = str_replace(' ', '', $first_data->order_number);
                        $purchase_order_number = str_replace(' ', '', $first_data->purchase_order_number);
                        $order_date = $first_data->order_date;
                        $order_time = $first_data->order_time;
                        $delivery_cycle = str_replace(' ', '', $first_data->delivery_cycle);
    
                        // Format number adalah : "order_iami_YYYYmmddHHiiss", 'YYYYmmddHHiiss' adalah format waktu
                        $number = 'order_iami' . "_" . $lyear . "_" . $lmonth . "_" . $lday . "_" . $lhour . "_" . $lminute . "_" . $lsecond;
                        $created_by = Auth::id();
    
                        $data1 = Order::where('order_number', $first_data->purchase_order_number)->count();
                        $data_arr[1] = array($data1);
    
                        if ($data1 == 0) {
                            $order =  Order::create([
                                'order_number' => $order_number,
                                'purchase_order_number' => $purchase_order_number,
                                'order_date' => $order_time,
                                'order_time' => $order_date,
                                'delivery_cycle' => $delivery_cycle,
                                'created_by' => $created_by,
                                'number' => $number,
                            ]);
    
                            foreach ($data as $key => $value) {
                                $order_list =  OrderList::create([
                                    'order_id' => $order->id,
                                    'part_number' => $value->part_number,
                                    'part_name' => $value->part_name,
                                    'order_qty' => $value->order_qty,
                                    'total_kanban' => $value->total_kanban,
                                    'kanban_qty' => $value->kanban_qty,
                                    'lp' => $value->lp,
                                ]);
    
                                for ($i = 0; $i < $order_list->total_kanban; $i++) {
                                    $d = Label::create([
                                        'order_id' => $order_list->order_id,
                                        'order_list_id' => $order_list->id,
                                        // Format Kanban Number adalah : order_number <spasi> part_number <spasi> nomor seri
                                        'kanban_number' => $order->order_number . ' ' . $value->part_number . ' ' . ($i),
                                        // Nomor seri dimulai berawalan nomor 1
                                        'serie_number' => $i + 1,
                                    ]);
                                }
                            }
                        }
                        }
    
                        foreach ($data_arr as $datatest1) {
                        $alert_atas = "gagal";
                        if ($datatest1[0] == 0) {
                            $alert_atas = "sukses";
                            break;
                        }
                        }
    
                        if ($alert_atas == "sukses") {
                        return back()->with('success', 'Upload success!');
                        } else {
                        return back()->with('errors', 'Upload Gagal!');
                        }
                    } else {
                        return back()->with('errors', 'Upload errors. Tidak ada data yang dapat ditambahkan! Mohon periksa kembali!');
                    }
                } else {
                    return back()->with('errors', 'Upload errors. File yang Anda unggah kosong! Periksa kembali file IAMI Order yang Anda unggah!');
                }
           } else {
              return back()->with('errors', 'Upload errors. Anda tidak melampirkan file!');
           }
  
           return back();
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $source['id'] = $id;
        $number = Order::select('order_number')->find($id);
  
        $details = Label::with('order', 'orderList')->where('order_id', $id)->get();
        foreach ($details as $key => $value) {
           $source['order_date'] = $value->order_date;
           $source['name'] = $value->name;
           break;
        }
  
        return view('iami.detailorder', [
           'details' => $details, 'id' => $source['id'], 'source' => $source,
           'number' => $number,
        ]);
    }


    public function sendOrder()
    {
       $nowdatetime = Carbon::now();
       
       $list_orders = Order::where('iami_orders.created_at', '>', $nowdatetime->subDays(14))
          ->join('users', 'users.id', '=', 'iami_orders.created_by')
          ->join('iami_labels', 'iami_labels.order_id', '=', 'iami_orders.id')
          ->join('iami_order_lists', 'iami_order_lists.order_id', '=', 'iami_orders.id')
          ->select('iami_orders.number', 'iami_orders.order_number', 'iami_orders.status', 'iami_orders.id', 'iami_orders.order_date', 'users.name')
          ->groupBy('iami_orders.order_number')
          ->get();
       
       return view('iami.sendorder', ['list_orders' => $list_orders]);
    }
 
    function monitor()
    {
       $nowdatetime = Carbon::now();
       $list_orders = Order::where('iami_orders.created_at', '>', $nowdatetime->subDays(20))
          ->join('users', 'users.id', '=', 'iami_orders.created_by')
          ->join('iami_labels', 'iami_labels.order_id', '=', 'iami_orders.id')
          ->join('iami_order_lists', 'iami_order_lists.order_id', '=', 'iami_orders.id')
          ->select('iami_orders.number', 'iami_orders.id', 'iami_orders.created_at', 'iami_orders.purchase_order_number', 'iami_orders.order_number', 'iami_orders.order_date', 'iami_orders.order_time', 'users.name', DB::raw('count(IF(iami_labels.msi_label_scan_at is NULL,1,NULL)) as totalnull'), DB::raw('count(iami_order_lists.total_kanban) as totalall'))
          ->orderBy('iami_orders.id', 'asc')
          ->groupBy('iami_orders.order_number')
          ->get();
       $monitor = "";
 
       return view('iami.monitor', ['list_orders' => $list_orders]);
    }
 
    public function monitorDetails($id)
    {
       $number = Order::select('order_number')->find($id);
       $details = order::where('iami_orders.id', $id)
          ->join('users', 'users.id', '=', 'iami_orders.created_by')
          ->join('iami_labels', 'iami_labels.order_id', '=', 'iami_orders.id')
          ->join('iami_order_lists', 'iami_order_lists.order_id', '=', 'iami_orders.id')
          ->select('iami_orders.order_number', 'iami_orders.id', 'iami_labels.order_id', 'iami_orders.order_date', 'iami_orders.status', 'iami_orders.purchase_order_number')
          ->groupBy('iami_orders.order_number')
          ->orderBy('iami_orders.order_number', 'asc')
          ->get();
       
       foreach ($details as $key => $value) {
          $label = Label::where(['order_id' => $value->order_id])->get();
 
          //Total Order
          $total_order = $label->count();
          $value->total_order = $total_order;
 
          //Total Complete
          $total_complete = $label->where('msi_label_scan_at', '!=', NULL)->count();
          $value->total_complete = $total_complete;
          if ($total_complete > 0) {
             if ($total_complete == $total_order) {
                $value->progress = "complete";
             } else {
                $value->progress = "progress";
             }
          } else {
             $value->progress = "open";
          }
       }
 
       return view(
          'iami.monitordetails',
          [
             'details' => $details, 'monitor' => $id,
             'number' => $number
          ]
       );
    }
 
    public function monitorList($id)
    {
       $number = Order::select('order_number')->find($id);
       $detail_label = Label::with('order', 'orderList')->where('order_id', $id)->get();
       foreach ($detail_label as $k => $v) {
          $order_number = $v->order_number;
       }
 
       $mot = "list";
       // dd($id .'/' . $mot);
       return view('iami.monitorlist', [
          'detail_label' => $detail_label,
          'order' => $id,
          'monitor' => $id, 'list' => $mot,
          'order_number' => $order_number,
          'number' => $number
       ]);
    }
 
    public function sendOrderDetails($id)
    {
       $number = Order::select('order_number')->find($id);
       $detail_orders = order::where('iami_orders.id', $id)
          ->join('users', 'users.id', '=', 'iami_orders.created_by')
          ->join('iami_labels', 'iami_labels.order_id', '=', 'iami_orders.id')
          ->join('iami_order_lists', 'iami_order_lists.order_id', '=', 'iami_orders.id')
          ->select('iami_orders.order_number', 'iami_orders.status', 'iami_orders.order_date', 'iami_orders.order_time', 'iami_labels.kanban_scan_by', 'iami_orders.purchase_order_number', 'iami_labels.kanban_number', 'iami_labels.msi_label_number', 'iami_labels.kanban_scan_at', 'iami_labels.msi_label_scan_by', 'users.name')
          ->groupBy('iami_orders.number')
          ->orderBy('iami_orders.order_number', 'asc')
          ->get();
       $total = (object)[
          'status'       => ($detail_orders->where('open', 'send'))->count(),
       ];
       return view('iami.sendorderdetails', [
          'detail_orders' => $detail_orders, 'id' => $id, 'total' => $total,
          'number' => $number
       ]);
    }
 
    public function sendProcess(Request $request, $id)
    {
       $status = 'send';
       $orderLists = Label::where('id', $id)->select('order_list_id')->get();
 
       $order = Order::where('id', $id)->update(['status' => $status]);
       $orderList = OrderList::where('id', $id)->update(['status' => $status]);
 
       foreach ($orderLists as $key => $value) {
          for ($i = 0; $i < $value->order_list_id; $i++) {
             $label = Label::where('order_list_id', $id)->update(['status' => $status]);
          }
       }
 
 
       return back()->with('success', 'Data berhasil disimpan....');
    }
 
    public function downloadReport($id)
    {
       $nowdatetime = Carbon::now();
       $nowdatetime = $nowdatetime->toDateTimeString();
       //  $datas = Label::where('orders_tmmin.do_no', $id)
       //      ->join('orders_tmmin', 'orders_tmmin.id', '=', 'label_tmmin.order_id')
       //      ->select('label_tmmin.do_no', 'label_tmmin.manifest_label_number', 'label_tmmin.manifest_label_scan_time', 'label_tmmin.msi_label_number', 'label_tmmin.msi_label_scan_time', 'label_tmmin.device_name', 'label_tmmin.user', 'label_tmmin.msi_label_scan_by', 'orders_tmmin.part_number', 'orders_tmmin.part_desc', 'orders_tmmin.lane_no', 'label_tmmin.order_no', 'label_tmmin.qty', 'label_tmmin.total_kanban', 'label_tmmin.order_qty')
       //      ->get();
       $order_number = Order::select('order_number')->find($id);
       $datas = Label::with('order', 'orderList')->where('order_id', $id)->get();
       $user = array('name' => Auth::user()->name, 'nik' => Auth::user()->nik);
       $user = $user['name'] . ' (' . $user['nik'] . ')';
       $pdf = PDF::loadView('iami.report', compact('datas', 'id', 'user', 'order_number'))->setPaper('a4', 'landscape');
       // return $pdf->stream();
       return $pdf->download('IAMI-Report_' . $nowdatetime . '_' . $id . '.pdf');
    }
 
    public function downloadReportExcel($id)
    {
       $nowdatetime = Carbon::now();
       $nowdatetime = $nowdatetime->toDateTimeString();
       $datas = Label::with('order', 'orderList')->where('order_id', $id)->get();
       $number = Order::select('order_number')->find($id);
       $data1 = $number->order_number;
 
       $excel = \Excel::create($data1, function ($excel) use ($id, $datas, $data1) {
 
          // Set the title
          $excel->setTitle("Report $id");
 
          // Chain the setters
          $excel->setCreator('WHS-Portal')->setCompany('PT Mah Sing Indonesia');
 
          // Make Sheet
          $excel->sheet('Report', function ($sheet) use ($id, $datas, $data1) {
             $row = 1;
             $sheet->mergeCells('A1:L1');
 
             $sheet->row($row, [
                "Scan Barcode Report for Purchase Order Number : $data1"
             ]);
             $row++;
 
             $sheet->row(
                $row,
                [
                   'No',
                   'Part Number',
                   'Part Name',
                   'Order Number',
                   'Qty',
                   'Purchase Order Number',
                   'Kanban Number',
                   'Kanban Scan Time',
                   'MSI Label Number',
                   'MSI Label Scan Time',
                   'User',
                ]
             );
             $row++;
 
             foreach ($datas as $key => $item) {
                $sheet->row(
                   $row,
                   [
                      $key + 1,
                      $item->orderList->part_number,
                      $item->orderList->part_name,
                      $item->order->order_number,
                      $item->orderList->order_qty,
                      $item->order->purchase_order_number,
                      $item->kanban_number,
                      $item->kanban_scan_at,
                      $item->msi_label_number,
                      $item->msi_label_scan_at,
                      Auth::user()->nik
                   ]
                );
                $row++;
             }
          });
       });
 
       return $excel->download('xlsx');
    }
 
 
    // DELETE
    public function destroy($id)
    {
         $count_label_process = DB::table('iami_labels')->where('order_id', '=', $id)->count();
       // $count_label_process = Order::where('id', '=', $id)->count();
 
       $labels = Label::where('order_id', $id)
          ->select(DB::raw('count(IF(msi_label_scan_at is NULL,1,NULL)) as totalnull'), DB::raw('count(order_id) as totalall'))
          ->get();
 
       $total_nulls = $labels[0]->totalall - $labels[0]->totalnull;
 
       if ($count_label_process == 0) {
          $output = array(
             'status' => 'delete'
          );
          if ($total_nulls == 0) {
             Order::where('id', '=', $id)->delete();
             OrderList::where('order_id', '=', $id)->delete();
             Label::where('order_id', '=', $id)->delete();
          } else {
             $output = array(
                'status' => 'cannot'
             );
             
          }
       } else {
          if ($total_nulls == 0) {
             $output = array(
                'status' => 'confirmation'
             );
          } else {
             $output = array(
                'status' => 'cannot'
             );
          }
       }
       echo json_encode($output);
    }
 
    public function forcedelete()
    {
       
       if (substr(Auth::user()->email, 0, 2) == 'it') {
          $details = DB::table('iami_orders')
             ->join('users', 'users.id', '=', 'iami_orders.created_by')
             ->join('iami_labels', 'iami_labels.order_id', '=', 'iami_orders.id')
             ->join('iami_order_lists', 'iami_order_lists.order_id', '=', 'iami_orders.id')
             ->select('iami_orders.order_number', 'users.name')
             ->groupBy('iami_orders.order_number')
             ->get();
          return view('iami.forcedelete', ['details' => $details]);
       } else {
          return back()->with('errors', 'Anda tidak memiliki akses ini. Silahkan hubungi pihak IT.');
       }
    }
 
    public function forcedeleteprocess(Request $request)
    {
       $orders = $request->input('orders');
 
       if ($orders <> " ") {
          foreach ($orders as $data) {
             $DO =   DB::table('iami_orders')
                ->join('users', 'users.id', '=', 'iami_orders.created_by')
                ->join('iami_labels', 'iami_labels.order_id', '=', 'iami_orders.id')
                ->join('iami_order_lists', 'iami_order_lists.order_id', '=', 'iami_orders.id')
                ->where('order_number', $data)
                ->select('order_number')
                ->groupBy('order_number')
                ->get();
             $history = array(
                'object'      => $data . ' : ' . $DO->implode('order_number', ', '),
                'source'      => 'IAMI',
                'reason'      => $request->input('reason'),
                'request_by'  => $request->input('request_by'),
                'approved_by' => $request->input('approved_by'),
                'deleted_by'  => Auth::user()->nik
             );
 
             $note =  DB::table('delete_history')->insert($history);
             $note =  DB::table('iami_labels')->where('order_id','=', $data)->delete();
             $note =  DB::table('iami_order_lists')->where('order_id','=',$data)->delete();
             $note =  DB::table('iami_orders')->where('id','=', $data)->delete();
          }
       }
       if ($note) {
          return back()->with('success', 'Data berhasil dihapus....');
       } else {
          return back()->with('errors', 'Data tidak terhapus pada database.');
       }
    }
}
