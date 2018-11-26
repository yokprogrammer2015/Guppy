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

        #text-h1 {
            font-size: 24px
        }

        #text-line {
            width: 725px;
            height: 1px;
            margin: 25px 0 25px 0;
            border-top: dashed;
        }

        .text-left {
            text-align: left;
            margin-left: 7px
        }
    </style>
</head>
<body>
@foreach($order as $row)
    @php
        if($row->adult) $person = 'Adult '.$row->adult; else $person = '';
        if($row->child) $person.= ' Child '.$row->child;
    @endphp
    <table width="100%">
        <tr>
            <td width="25%"><strong id="text-h1">ADV ./</strong> <strong>{{ $row->branch->name }}</strong></td>
            <td><strong>EXCHANGE VOUCHER</strong></td>
            <td width="25%"><strong>NO {{ $row->ticket_no }}</strong></td>
        </tr>
        <tr>
            <td><strong>SERVICE ORDER TO</strong></td>
            <td colspan="2">
                <div class="text-left">ADV {{ $row->serviceBranch->name }} / TEL : {{ $row->serviceBranch->phone }}
                    Fax : {{ $row->serviceBranch->fax }}</div>
            </td>
        </tr>
        <tr>
            <td><strong>DATE OF TRAVEL</strong></td>
            <td>
                <div class="text-left">{{ $getFunction->DateFormat($row->travel_date, 'm') }}</div>
            </td>
            <td>No. of passenger (S)</td>
        </tr>
        <tr>
            <td><strong>CLIENT NAME</strong></td>
            <td>
                <div class="text-left">{{ $row->name }}</div>
            </td>
            <td>{{ $person }}</td>
        </tr>
        <tr>
            <td rowspan="2"><strong>SERVICE DESCRIPTION</strong></td>
            <td colspan="2">
                <div class="text-left">Transfer from {{ $row->departure->name }} - {{ $row->arrive->name }}.<br>
                    Departure time: {{ $row->time->name }}.
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="text-left">ORDER BY : {{ $row->agent->ag_name }} # {{ $row->voucher_no }}<br>
                    ISSUE BY : {{ $row->member->mb_name }}<br>
                    ISSUE DATE : {{ $getFunction->DateFormat(substr($row->creation_date, 0, 10), 's') }}
                </div>
            </td>
        </tr>
        <tr>
            <td><strong>TERAM AND CONDITIONS</strong></td>
            <td colspan="2">
                <div class="text-left">The above transfer service is approximate and can be changed without notice<br>
                    depending on the suitability sea and weather conditions.<br>
                    In case of changing travel date please do it at least one or two days before.<br>
                    <strong>NON REFUND FOR UNUSED TICKET IN ANY CIRCUMSTANCES.</strong></div>
            </td>
        </tr>
    </table>
    <div id="text-line"></div>
    <table width="100%">
        <tr>
            <td width="25%"><strong id="text-h1">ADV ./</strong> <strong>{{ $row->branch->name }}</strong></td>
            <td><strong>EXCHANGE VOUCHER</strong></td>
            <td width="25%"><strong>NO {{ $row->ticket_no }}</strong></td>
        </tr>
        <tr>
            <td><strong>SERVICE ORDER TO</strong></td>
            <td colspan="2">
                <div class="text-left">ADV {{ $row->serviceBranch->name }} / TEL : {{ $row->serviceBranch->phone }}
                    Fax : {{ $row->serviceBranch->fax }}</div>
            </td>
        </tr>
        <tr>
            <td><strong>DATE OF TRAVEL</strong></td>
            <td>
                <div class="text-left">{{ $getFunction->DateFormat($row->travel_date, 'm') }}</div>
            </td>
            <td>No. of passenger (S)</td>
        </tr>
        <tr>
            <td><strong>CLIENT NAME</strong></td>
            <td>
                <div class="text-left">{{ $row->name }}</div>
            </td>
            <td>{{ $person }}</td>
        </tr>
        <tr>
            <td rowspan="2"><strong>SERVICE DESCRIPTION</strong></td>
            <td colspan="2">
                <div class="text-left">Transfer from {{ $row->departure->name }} - {{ $row->arrive->name }}.<br>
                    Departure time: {{ $row->time->name }}.
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="text-left">ORDER BY : {{ $row->agent->ag_name }} # {{ $row->voucher_no }}<br>
                    ISSUE BY : {{ $row->member->mb_name }}<br>
                    ISSUE DATE : {{ $getFunction->DateFormat(substr($row->creation_date, 0, 10), 's') }}
                </div>
            </td>
        </tr>
        <tr>
            <td><strong>TERAM AND CONDITIONS</strong></td>
            <td colspan="2">
                <div class="text-left">The above transfer service is approximate and can be changed without notice<br>
                    depending on the suitability sea and weather conditions.<br>
                    In case of changing travel date please do it at least one or two days before.<br>
                    <strong>NON REFUND FOR UNUSED TICKET IN ANY CIRCUMSTANCES.</strong></div>
            </td>
        </tr>
    </table>
@endforeach
</body>
</html>