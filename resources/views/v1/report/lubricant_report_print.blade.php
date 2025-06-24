<html>

<head>

    <title>Lubricant Report</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/report.css') }}">

    <link href="https://fonts.maateen.me/siyam-rupali/font.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/app.css') }}">
    <style>
        @media print {
            .wrapper {
                page-break-after: always;
            }
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
                        <td valign='top'><img style="height: 75px; width: 80px" src="{{asset
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
                            <td width="20%" style="padding-top:0px;">
                           <img style="height: 70px; width: 117px" src="{{asset
                            ('/assets/images/.png')}}" class='logo pull-right'/>
                           </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"colspan="4">
                    <h2 style="text-decoration: underline;">
                        লুব্রিক্যান্ট রিপোর্ট
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

                            <td width="10%" style="text-align: center">নং</td>
                            <td width="15%" style="text-align: center">তারিখ</td>
                            <td width="20%" style="text-align: center">ড্রাইভারের নাম:</td>
                            <td width="20%" style="text-align: center">গাড়ি নং</td>
                            <td width="10%" style="text-align: center">টাইপ</td>
                            <td width="15%" style="text-align: center">পূর্ববর্তী জমা</td>
                            <td width="10%" style="text-align: center">সরবারহ</td>
                            <td width="15%" style="text-align: center">মোট টাকা</td>


                        </tr>
                        @php
                            $i=0;
                            $total = 0;
                            $lubricant_type = [1=>'প্রেক্টল',2=>'ডিজেল',3=>'অকটেন',4=>'ইঞ্জিন অয়েল',5=>'গিয়ার অয়েল',6=>'গ্রীজ',7=>'পাওয়ার অয়েল',8=>'হাইড্রলীক অয়েল',9=>'ব্রেক অয়েল'];

                        @endphp
                        @foreach($lubricant_data as $key=> $item)
                            <tr>
                                <td style="text-align: center;">{{++$i}}</td>
                                <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                                <td>{{$item->driver_name}}</td>
                                <td>{{$item->vehicle_reg_no}}</td>
                                <td>{{$lubricant_type[$item->type]}}</td>
                                <td>{{$item->previous_stock}} লিটার</td>
                                <td>{{$item->in}} লিটার</td>
                                <td style="text-align: right">{{$item->payment}}</td>
                                @php
                                    $total += $item->payment
                                @endphp
                            </tr>



                        @php
                            if (($key+1) % 18 == 0 && count($lubricant_data) > $key+1):
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
                            <td valign="top"><img style="height: 75px; width: 80px" src="'.@asset
                            ('/assets/images/feni_pou.png').'" class="logo pull-right"/></td>
                            <td width="60%">
                                <table class="table" width="100%;" border="0" cellpadding="0" cellpadding="0"
                                       style="border-collapse:collapse;line-height: 1.3">
                                    <tr>
                                        <td width="100%" align="center">
                                            <p
                                                style="font-size:25px;font-weight:bold; text-align:center;padding:
                                                5px">' .@$org->name.'
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" align="center">
                                                <span style="font-size:16px; font-weight:normal;text-align:center;">
                                                '.@$org->address.'
                                                </span>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                            <td width="20%" style="padding-top:50px;">
                            <img style="height: 70px; width: 117px" src="'.@asset
                            ('/assets/images/.png').'" class="logo pull-right"/>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"colspan="4">
                    <h2 style="text-decoration: underline;">
                        লুব্রিক্যান্ট রিপোর্ট
                    </h2>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="tbl_style" cellpadding="2" style="border-collapse:collapse;">

                        <tr style="font-weight: bold;">

                            <td width="10%" style="text-align: center">নং</td>
                            <td width="15%" style="text-align: center">তারিখ</td>
                            <td width="20%" style="text-align: center">ড্রাইভারের নাম:</td>
                            <td width="20%" style="text-align: center">গাড়ি নং</td>
                            <td width="10%" style="text-align: center">টাইপ</td>
                            <td width="15%" style="text-align: center">পূর্ববর্তী জমা</td>
                            <td width="10%" style="text-align: center">সরবারহ</td>
                            <td width="15%" style="text-align: center">মোট টাকা</td>


                        </tr>';
                        endif;
                        @endphp
                        @endforeach

                        </tbody>
                            <tr>

                                <td style="text-align: right;font-weight:bold" colspan="7">সর্ব মোটঃ</td>
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

