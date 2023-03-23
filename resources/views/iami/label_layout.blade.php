<!DOCTYPE html>
<html>
<head>
    <title>KANBAN TMMIN | {{date('Ymd')}}</title>
	<style type="text/css">
		@page { margin: 5px; margin-top: 15px; }
		body { 
            margin: 10px;
            font-family: Arial, Helvetica, sans-serif;
            text-transform: uppercase;
            font-weight: bold;
        }
        table{
            border: none;
            width: 100%;
        }
        td > table{
            border: 1.5px solid black;
            border-collapse: collapse;
            text-align: center;
            margin-bottom: 2px;
        }
        th{
            background-color: #d8d8d8;
            border: 1px solid black;
            text-align: center;
            padding: -1px;
        }
		hr {
			border: 1px dotted black;
			margin-top: 2px;
			margin-bottom: 9px;
		}
	</style>
</head>
<body>
    @php
        $i = 0;
    @endphp
    @for ($i = 0; $i < count($data); $i++)
    <table style="margin-bottom: -8px;">
        <tr>
            <td style="width: 281px; max-width: 281px; vertical-align: top;">
                <table>
                    <thead>
                        <tr>
                            <th>Supplier</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14.5px;">
                        <tr>
                            <td style="height: 71px; vertical-align: middle;">
                                <div style="">MAH SING INDONESIA (CIKARANG)</div>
                                <div style="font-size: 32px; padding-top: 8px;">{{$data[$i]['supplier_code']}}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th>Arrival Time</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14.5px;">
                        <tr>
                            <td style="height: 51px;">
                                <div style="">
                                    <span style="font-size: 32px; vertical-align: middle;">{{date_format(date_create($data[$i]['arr_date']), 'd/m/')}}</span>
                                    <span style="font-size: 24px; vertical-align: middle;">{{date_format(date_create($data[$i]['arr_date']), 'Y-H:i')}}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th>Supplier Data</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14.5px;">
                        <tr>
                            <td style="height: 111px;">
                                <div style="padding-bottom: 26px;">
                                    <img style="height: 40px; width: 255px;" src="data:image/png;base64,{{ $barcodes[$i]['label_number'] }}" />
                                </div>
                                <div style="font-size: 27px; vertical-align: bottom;">{{$data[$i]['supplier_data']}}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 275px; vertical-align: top;">
                <table style="border: none;">
                    <tr>
                        <td style="height: 93px; vertical-align: middle; font-size: 14.5px;">
                            <div style="">PT. TOYOTA MOTOR</div>
                            <div style="">MANUFACTURING INDONESIA</div>
                            <div style="font-size: 29.5px; padding-top: 8px;">{{$data[$i]['location']}}</div>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="height: 70px; vertical-align: top; font-size: 15px;">
                            <table style="border: none;">
                                <tr>
                                    <td style="font-size: 24px;">{{substr($data[$i]['part_number'], 1, -1)}}</td>
                                </tr>
                                <tr>
                                    <td style="height: 34px; vertical-align: middle;">{{$data[$i]['part_desc']}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th>Unique No</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14.5px;">
                        <tr>
                            <td style="height: 50px;">
                                <div style="font-size: 40px; vertical-align: bottom;">{{$data[$i]['uniq_no']}}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th style="font-size: 13px; padding: 2px; width: 100px;">Pcs/Kanban</th>
                            <th style="font-size: 13px; padding: 2px;">Order No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="height: 34px; font-size: 26px; border-right: 1px solid black;">{{$data[$i]['qty_box']}}</td>
                            <td style="border-right: 1px solid black;">
                                <span style="vertical-align: middle;">{{substr($data[$i]['order_no'], 0, 4)}}</span> <span style="font-size: 24px; vertical-align: middle;">{{substr($data[$i]['order_no'], 4, 4)}}</span> <span style="vertical-align: middle;">{{substr($data[$i]['order_no'], 8)}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 194px; max-width: 194px; vertical-align: top;">
                <span style="position: absolute; padding: -10px;">
                    <img style="width: 220px; height: 40px; display: block; margin-top: 14px; margin-left: 25px; transform-origin: top left; transform: rotate(-90deg) translate(-100%); white-space: nowrap;" src="data:image/png;base64,{{ $barcodes[$i]['part_number'] }}">                    
                </span>
                <span>
                    <table style="">
                        <tr>
                            <td style="">
                            </td>
                            <td style="width: 138px;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Dock Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 40px;">{{$data[$i]['dock_code']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">Progress Lane No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 40px; height: 55px;">{{str_pad($data[$i]['lane_no'], 2, '0', STR_PAD_LEFT)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="font-size: 13px;">Conveyance No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 40px; height: 53px;">{{$data[$i]['conveyance_no']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </span>
                <table>
                    <thead>
                        <tr>
                            <th>Part Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size: 26px; height: 53px;">{{$data[$i]['part_address']}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <span style="padding-left: 10px; text-transform: none; font-weight: none; font-size: 12px; font-style: italic;">Printed at Supplier on: {{date('n/j/Y g:i:s A')}}</span>
    <hr>
    @endfor
</body>
</html>
