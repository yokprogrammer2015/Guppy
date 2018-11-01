<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 18px;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        td, th {
            border: 1px solid;
        }

        #page_title {
            width: 1200px;
            height: auto;
            float: left;
        }

        #ds_type {
            width: 200px;
            height: 30px;
            float: left;
            font-weight: bold;
        }

        #ds_title {
            width: 420px;
            height: 30px;
            float: left;
            text-align: right;
            font-size: 32px;
            margin-left: 200px;
            font-weight: bold;
        }

        #ds_book {
            width: 100px;
            height: 30px;
            float: left;
            margin-left: 850px;
            font-weight: bold;
        }

        #ds_no {
            width: 100px;
            height: 30px;
            float: left;
            margin-left: 960px;
            font-weight: bold;
        }

        #page_date {
            width: 200px;
            height: 25px;
            margin: 40px 0 20px 870px;
        }

        #date_title {
            width: 60px;
            height: 25px;
            float: left;
        }

        #date_bottom {
            width: 100px;
            height: 25px;
            float: left;
            border-bottom: dotted;
        }

        #page_bottom {
            width: 1200px;
            height: auto;
            float: left;
            margin-top: 30px;
        }

        #bottom1 {
            width: 20px;
            height: 20px;
            float: left
        }

        #bottom2 {
            width: 250px;
            height: 25px;
            float: left;
            margin-left: 40px;
            border-bottom: dotted;
        }

        #bottom3 {
            width: 20px;
            height: 20px;
            float: left;
            margin-left: 360px;
        }

        #bottom4 {
            width: 250px;
            height: 25px;
            float: left;
            margin-left: 400px;
            border-bottom: dotted;
        }

        #bottom5 {
            width: 20px;
            height: 20px;
            float: left;
            margin-left: 720px;
        }

        #bottom6 {
            width: 250px;
            height: 25px;
            float: left;
            margin-left: 770px;
            border-bottom: dotted;
        }

        #bottom7 {
            width: 290px;
            height: 25px;
            float: left;
            margin: 40px 0 0 0;
            border-bottom: dotted;
        }

        #bottom8 {
            width: 290px;
            height: 25px;
            float: left;
            margin: 40px 0 0 360px;
            border-bottom: dotted;
        }

        #bottom9 {
            width: 300px;
            height: 25px;
            float: left;
            margin: 40px 0 0 720px;
            border-bottom: dotted;
        }

        #tag1 {
            width: 10px;
            height: 25px;
            margin-left: 86px;
        }

        #tag2 {
            width: 300px;
            height: 25px;
            margin-left: 86px;
        }

        #tag3 {
            width: 600px;
            height: 25px;
            margin-left: 86px;
        }

        #tag_all {
            height: 25px;
            margin: -25px 0 0 192px;
        }
    </style>
</head>
<body>
<div id="page_title">
    <div id="ds_type">{{ $type_name }} / {{ $category->con_name }}</div>
    <div id="ds_title">DAILY
        SALE REPORT
    </div>
    <div id="ds_book">เล่มที่ {{ $ds_book }}</div>
    <div id="ds_no">เลขที่ {{ $ds_no }}</div>
</div>
<div id="page_date">
    <div id="date_title">ประจำวันที่</div>
    <div id="date_bottom"></div>
</div>
<table width="100%">
    <thead>
    <tr>
        <th rowspan="2">Ticket No</th>
        <th rowspan="2">Route</th>
        <th rowspan="2">Travel Date</th>
        <th rowspan="2">Agent</th>
        <th rowspan="2">Adult</th>
        <th rowspan="2">Child</th>
        <th colspan="2">Price</th>
        <th colspan="2">Net</th>
        <th colspan="2">Total</th>
        <th rowspan="2">Profit</th>
        <th rowspan="2">Remark</th>
    </tr>
    <tr>
        <th>Adult</th>
        <th>Child</th>
        <th>Adult</th>
        <th>Child</th>
        <th>Price</th>
        <th>Net</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order as $row)
        @php
            $sell_total = (int)($row->adult * $row->price_adult) + ($row->child * $row->price_child);
            $net_total = (int)($row->adult * $row->net_adult) + ($row->child * $row->net_child);
            $profit = (int)($sell_total - $net_total);

            $grand_sell += $sell_total;
            $grand_net += $net_total;
            $grand_profit += $profit;
        @endphp
        <tr>
            <td>{{ $row->ticket_no }}</td>
            <td>{{ $row->departure->con_name }} - {{ $row->arrive->con_name }}</td>
            <td>{{ $getFunction->DateFormat($row->travel_date, 's') }}</td>
            <td>{{ $row->agent->ag_name }}</td>
            <td>{{ $row->adult }}</td>
            <td>{{ $row->child }}</td>
            <td>{{ $row->price_adult }}</td>
            <td>{{ $row->price_child }}</td>
            <td>{{ $row->net_adult }}</td>
            <td>{{ $row->net_child }}</td>
            <td>{{ $sell_total }}</td>
            <td>{{ $net_total }}</td>
            <td>{{ $profit }}</td>
            <td>{{ $row->voucher_no }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="10" align="right">Grand Total &nbsp;&nbsp;&nbsp;</td>
        <td>{{ $grand_sell }}</td>
        <td>{{ $grand_net }}</td>
        <td>{{ $grand_profit }}</td>
        <td></td>
    </tr>
    </tbody>
</table>
<div id="page_bottom">
    <div id="bottom1">ผู้บันทึก</div>
    <div id="bottom2"></div>
    <div id="bottom3">ผู้รับเงิน</div>
    <div id="bottom4"></div>
    <div id="bottom5">ผู้ลงบัญชี</div>
    <div id="bottom6"></div>
    <div id="bottom7">
        <div id="tag1">/</div>
        <div id="tag_all">/</div>
    </div>
    <div id="bottom8">
        <div id="tag2">/</div>
        <div id="tag_all">/</div>
    </div>
    <div id="bottom9">
        <div id="tag3">/</div>
        <div id="tag_all">/</div>
    </div>
</div>
</body>
</html>