<html>

<head>

    <title>Repairs Report</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/report.css') }}">

    <link href="https://fonts.maateen.me/siyam-rupali/font.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/app.css') }}">
    <style>
        @media print {
            .wrapper {
                page-break-after: always;
            }
        }
        .wrapper {
            width: auto;
            height: auto;
            padding: 1em;
            margin: 0 auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>
<img style="float: right;" src="{{ asset('/assets/images/print_big.png') }}" onclick="window.print()" id="hide"
     height="50" width="50">

<div class="wrapper" attr="none">
    <div class="jolchap">
        <table style="font-size:12px;" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td colspan="4">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                        <td valign='top'><img style="margin-left:65px; height: 75px; width: 80px" src="{{asset
                            ('/assets/images/feni_pou.png')}}" class='logo pull-right'/></td>
                            <td width="60%">
                                <table class="table" width="100%;" border="0" cellpadding="0" cellpadding="0"
                                       style="border-collapse:collapse;line-height: 1.3">
                                    <tr>
                                        <td width="100%" align="center">
                                            <p
                                                style="font-size:25px;font-weight:bold; text-align:center;padding:
                                                5px">

                                                {{$org->name}}

                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" align="center">
                                                <span style="font-size:16px; font-weight:normal;text-align:center;">
                                                   {{$org->address}}
                                                </span>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                            <td valign='top'><img style="margin-right: -155px; height: 70px; width: 120px" src="{{asset
                            ('/assets/images/.png')}}" class='logo pull-right'/></td>
                            <td width="20%" style="padding-top: 50px;">

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"colspan="4">
                    <h2 style="text-decoration: underline;">
                        যন্ত্রাংশ রিপোর্ট
                    </h2>
                </td>
            </tr>

            <tr>
                <td style="text-align: center;"colspan="4">
                    <h2 style="text-decoration: underline;">
                        {{$from}} থেকে {{$to}} পর্যন্ত
                    </h2>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <table class="tbl_style" cellpadding="2" style="border-collapse:collapse;">

                        <tr style="font-weight: bold;">

                            <td width="5%" style="text-align: center">নং</td>
                            <td width="10%" style="text-align: center">তারিখ</td>
                            <td width="10%" style="text-align: center">ড্রাইভারের নাম</td>
                            <td width="10%" style="text-align: center">গাড়ি নং</td>
                            <td width="20%" style="text-align: center">নষ্ট যন্ত্রাংশ</td>
                            <td width="20%" style="text-align: center">নতুন যন্ত্রাংশ</td>
                            <td width="10%" style="text-align: center">যন্ত্রাংশের দোকান / সার্ভিস সেন্টার</td>
                            <td width="15%" style="text-align: center">মেরামতকৃত যন্ত্রাংশ</td>
                            <td width="10%" style="text-align: center">খরচের পরিমাণ</td>

                        </tr>
                        @php
                            $i=0;
                            $total = 0
                        @endphp
                        @foreach($repairs_data as $key=> $item)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{date("d-m-Y", strtotime($item->issue_date))}}</td>
                                <td>{{$item->driver_name}}</td>
                                <td>{{$item->vehicle_reg_no}}</td>
                                <td>{{$item->damage_parts}}</td>
                                <td>{{$item->new_parts}}</td>
                                <td>{{$item->shop_name}}</td>
                                <td>{{$item->cause_of_problems}}</td>
                                <td style="text-align: right">{{$item->total_cost}}</td>
                                @php
                                    $total += $item->total_cost
                                @endphp
                            </tr>
                            @php
                            if (($key+1) % 10 == 0 && count($repairs_data) > $key+1):
                            echo '</table>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="height:40px;"></td>
            </tr>
        </table>
    </div>

</div><div class="wrapper" attr="none">
    <div class="jolchap">
        <table style="font-size:12px;" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td colspan="4">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td valign="top"><img style="margin-left:65px; height: 75px; width: 80px" src="'.@asset
                            ('/assets/images/feni_pou.png').'" class="logo pull-right"/></td>
                            <td width="60%">
                                <table class="table" width="100%;" border="0" cellpadding="0" cellpadding="0"
                                       style="border-collapse:collapse;line-height: 1.3">
                                    <tr>
                                        <td width="100%" align="center">
                                            <p
                                                style="font-size:25px;font-weight:bold; text-align:center;padding:
                                                5px">

                                                '.$org->name.'

                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" align="center">
                                                <span style="font-size:16px; font-weight:normal;text-align:center;">
                                                   '.$org->address.'
                                                </span>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                            <td valign="top"><img style="margin-right: -155px; height: 70px; width: 120px" src="'.@asset
                            ('/assets/images/.png').'" class="logo pull-right"/></td>
                            <td width="20%" style="padding-top:50px;">

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"colspan="4">
                    <h2 style="text-decoration: underline;">
                        যন্ত্রাংশ রিপোর্ট
                    </h2>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="tbl_style" cellpadding="2" style="border-collapse:collapse;">

                        <tr style="font-weight: bold;">

                            <td width="5%" style="text-align: center">নং</td>
                            <td width="10%" style="text-align: center">তারিখ</td>
                            <td width="10%" style="text-align: center">ড্রাইভারের নাম</td>
                            <td width="10%" style="text-align: center">গাড়ি নং</td>
                            <td width="20%" style="text-align: center">নষ্ট যন্ত্রাংশ</td>
                            <td width="20%" style="text-align: center">নতুন যন্ত্রাংশ</td>
                            <td width="10%" style="text-align: center">যন্ত্রাংশের দোকান / সার্ভিস সেন্টার</td>
                            <td width="15%" style="text-align: center">মেরামতকৃত যন্ত্রাংশ</td>
                            <td width="10%" style="text-align: center">খরচের পরিমাণ</td>

                        </tr>';
                        endif;
                        @endphp
                        @endforeach
                            </tbody>
                            <tr>

                                <td style="text-align: right;font-weight:bold" colspan="8">সর্ব মোটঃ</td>
                                <td style="text-align: right;font-weight:bold">{{$total}}.00</td>
                            </tr>
                    </table>

                </td>
            </tr>

            <tr>
                <td colspan="4" style="height:40px;"></td>
            </tr>
        </table>
    </div>

</div>


</body>

</html>

