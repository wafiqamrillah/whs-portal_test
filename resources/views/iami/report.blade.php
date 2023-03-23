<!DOCTYPE html>
<html>
	<head>
		<title>IAMI Report {{$id}}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <style type="text/css">
			table{
                border: 1px solid black;
                border-collapse: collapse;
				width: 136%;
			}
            th{
                text-align: center;
            }
			td, th{
				border:1px solid black;
				font-size: 10px;
			}
            .table-identifier{
                border-style: hidden;
                font-weight: bold;
            }
			html,body { 
				height:297mm;
    			width:210mm; 
                margin-top: 10px;
                margin-bottom: auto;
				margin-left:10px; 
				margin-right:auto; 
				font-size: 9px;
                font-family: Arial, Helvetica, sans-serif;
			}
			.head-table1 {
				font-size: 1em;
				border: 0.5px;
			}
			.page-break {
    			page-break-after: always;
    		}
		</style>
	</head>
	<body>
		Scan Barcode Report for Manifest Number : {{$order_number->order_number}}<span style="float: right;">Printed by : {{ $user }}</span><br>
        <table>
            <thead>
                <tr>
                    <th style="width: 1%;">No.</th>
                    <th style="width: 10%;">Part Number</th>
                    <th>Part Name</th>
                    <th style="width: 1%;">Order Number</th>
                    <th style="width: 1%;">Qty</th>
                    <th style="width: 10%;">Purchase Order Number</th>
                    <th style="width: 10%;">Kanban Number</th>
                    <th style="width: 10%;">Kanban Scan Time</th>
                    <th style="width: 10%;">MSI Label Number</th>
                    <th>MSI Label Scan Time</th>
                    <th style="width: 1%;">User</th>
                    <th>No. Pallet</th>
                </tr>
            </thead>
            <tbody><?php $no = 1;?>
            	@foreach ($datas as $data)
                <tr>
                  	<td style="text-align: center;">{{ $no }}</td>
                    <td style="">{{ $data->orderList->part_number }}</td>
                    <td style="">{{ $data->orderList->part_name }}</td>
                    <td style="text-align: center;">{{ $data->order->order_number }}</td>
                    <td style="text-align: right;">{{ $data->orderList->order_qty }}</td>
                    <td style="text-align: right;">{{ $data->order->purchase_order_number }}</td>
                    <td style="">{{ $data->kanban_number }}</td>
                    <td style="">{{ $data->kanban_scan_at }}</td>
                    <td style="">{{ $data->msi_label_number }}</td>
                    <td style="text-align: center;">{{ $data->msi_label_scan_at }}</td>
                    <td style="">{{ Auth::user()->nik }}</td>
                    <td style=""></td>
                </tr>   
                <?php $no = $no + 1; ?> 
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 1%;">No.</th>
                    <th style="width: 10%;">Part Number</th>
                    <th>Part Name</th>
                    <th style="width: 1%;">Order Number</th>
                    <th style="width: 1%;">Qty</th>
                    <th style="width: 10%;">Purchase Order Number</th>
                    <th style="width: 10%;">Kanban Number</th>
                    <th style="width: 10%;">Kanban Scan Time</th>
                    <th style="width: 10%;">MSI Label Number</th>
                    <th>MSI Label Scan Time</th>
                    <th style="width: 1%;">User</th>
                    <th>No. Pallet</th
                </tr>
            </tfoot>
        </table>
        <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="bower_components/datatables.net/js/custom.dataTable.js"></script>
	</body>
</html>
