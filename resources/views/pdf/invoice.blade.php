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

        #page {
            background: #ffffff;
            width: 800px;
            margin: 0 auto;
            padding: 0 10px 0 10px;
        }

        #page_group {
            width: 1000px;
            height: auto;
            float: left;
        }

        #page_left {
            width: 250px;
            height: 80px;
            float: left;
        }

        #page_left2 {
            width: 200px;
            height: 80px;
            border: 1px solid;
            margin-top: 80px;
            float: left;
        }

        #page_right {
            width: 150px;
            height: 80px;
            float: left;
            text-align: right;
            margin-left: 500px;
        }

        #page_right2 {
            width: 150px;
            height: 80px;
            float: left;
            border: 1px solid;
            padding: 0 2px 0 5px;
            margin-top: 80px;
            margin-left: 550px;
        }

        #page_table {
            width: 710px;
            height: auto;
            margin-top: 200px;
        }

        #page_bottom {
            width: 710px;
            height: auto;
            float: left;
            margin-top: 30px;
        }

        #inv_date {
            width: 150px;
            height: 40px;
            float: left;
            border-bottom-style: solid
        }

        #inv_no {
            width: 150px;
            height: 40px;
            margin-top: 40px
        }

        #bottom1 {
            width: 20px;
            height: 20px;
            float: left
        }

        #bottom2 {
            width: 180px;
            height: 25px;
            float: left;
            margin-left: 40px;
            border-bottom: dotted;
        }

        #bottom3 {
            width: 20px;
            height: 20px;
            float: left;
            margin-left: 240px;
        }

        #bottom4 {
            width: 180px;
            height: 25px;
            float: left;
            margin-left: 280px;
            border-bottom: dotted;
        }

        #bottom5 {
            width: 20px;
            height: 20px;
            float: left;
            margin-left: 480px;
        }

        #bottom6 {
            width: 180px;
            height: 25px;
            float: left;
            margin-left: 520px;
            border-bottom: dotted;
        }

        #bottom7 {
            width: 220px;
            height: 25px;
            float: left;
            margin: 40px 0 0 0;
            border-bottom: dotted;
        }

        #bottom8 {
            width: 220px;
            height: 25px;
            float: left;
            margin: 40px 0 0 240px;
            border-bottom: dotted;
        }

        #bottom9 {
            width: 220px;
            height: 25px;
            float: left;
            margin: 40px 0 0 480px;
            border-bottom: dotted;
        }
    </style>
</head>
<body>
<div id="page">
    <div id="page_group">
        <div id="page_left">
            <strong style="font-size: 24px">บริษัท ส่งเสริมรุ่งเรือง</strong><br>
            <span>โทร. {{ $phone }} {{ $mobile }} {{ $fax }}</span>
        </div>
        <div id="page_right">
            <strong style="font-size: 36px">{{ $title }}</strong>
        </div>
        <div id="page_left2">
            <div style="padding: 10px 0 0 10px">
                <strong style="font-size: 24px">Bill TO : {{ $ag_name }}</strong>
            </div>
        </div>
        <div id="page_right2">
            <div id="inv_date">
                Date {{ $inv_date }}
            </div>
            <div id="inv_no">
                Invoice #{{ $inv_no }}
            </div>
        </div>
    </div>

    <div id="page_table">
        <table width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Voucher No</th>
                <th>Order</th>
                <th>Adult</th>
                <th>Child</th>
                <th>Price Adult</th>
                <th>Price Child</th>
                <th>Total</th>
                <th>Travel Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoiceDetail as $k => $row)
                @php
                    $sell_total = (int)($row->order->adult * $row->order->price_adult) + ($row->order->child * $row->order->price_child);
                    $grand_total += $sell_total;
                @endphp
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $row->order->voucher_no }}</td>
                    <td>{{ $row->route->code }} - {{ $row->routeTo->code }}</td>
                    <td>{{ $row->order->adult }}</td>
                    <td>{{ $row->order->child }}</td>
                    <td>{{ $row->order->price_adult }}</td>
                    <td>{{ $row->order->price_child }}</td>
                    <td>{{ number_format($sell_total) }}</td>
                    <td>{{ $row->order->travel_date }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td colspan="6">{{ $getFunction->bahtThai($grand_total) }}</td>
                <td>{{ number_format($grand_total) }}</td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        <div id="page_bottom">
            <div id="bottom1">ผู้จัดส่ง</div>
            <div id="bottom2"></div>
            <div id="bottom3">ผู้รับบิล</div>
            <div id="bottom4"></div>
            <div id="bottom5">ผู้รับเงิน</div>
            <div id="bottom6"></div>
            <div id="bottom7"></div>
            <div id="bottom8"></div>
            <div id="bottom9"></div>
        </div>
    </div>
</div>
</body>
</html>