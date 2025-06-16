<html>

<head>

    <title>RentalCar Report</title>
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
            width: 26.8cm;
            height: 21cm;
            padding: 1em;
            margin: 0 auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
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
                                            <p style="font-size:25px;font-weight:bold; text-align:center;padding:
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
                            <td width="20%" style="padding-top:;">
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
                        ভাড়ায় গাড়ির রিপোর্ট
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
{{--                            <td width="15%" style="text-align: center">তারিখ</td>--}}
                            <td width="10%" style="text-align: center">গাড়ির নং</td>
                            <td width="10%" style="text-align: center">ঠিকাদারের নাম</td>
                            <td width="10%" style="text-align: center">ঠিকানা</td>
                            <td width="10%" style="text-align: center">তারিখ(থেকে)</td>
                            <td width="10%" style="text-align: center">তারিখ(পর্যন্ত)</td>
                            <td width="10%" style="text-align: center">মোট দিন</td>
                            <td width="10%" style="text-align: center">ভাড়া</td>
                            <td width="10%" style="text-align: center">ভ্যাট(১৫%)</td>
                            <td width="10%" style="text-align: center">আয়কর(৫%)</td>
                            <td width="10%" style="text-align: center">মোট টাকা</td>
{{--                            <td width="10%" style="text-align: center">অকেজোর তারিখ</td>--}}


                        </tr>
                        @php
                            $i=0;
                            $total = 0;
                            $total_amount=0;
                            $total_vat=0;
                            $total_income_tax=0;

                        @endphp
                        @foreach($rentalcar_info as $item)
                            <tr>
                                <td style="text-align: center">{{++$i}}</td>
{{--                                <td style="text-align: center">{{date('d-m-Y',strtotime($item->insert_date))}}</td>--}}
                                <td style="text-align: center">{{$item->vehicle_reg_no}}| {{$item->body_type}}</td>
                                <td style="text-align: center">{{$item->contractor_name}}</td>
                                <td style="text-align: center">{{$item->address}}</td>
                                <td style="text-align: center">{{$item->from_date}}</td>
                                <td style="text-align: center">{{$item->to_date}}</td>
                                <td style="text-align: center">{{$item->total_day}}</td>
                                <td style="text-align: right">{{number_format($item->amount ,2)}}</td>
                                <td style="text-align: right">{{number_format($item->vat ,2)}}</td>
                                <td style="text-align: right">{{number_format($item->income_tax ,2)}}</td>
                                <td style="text-align: right;">{{number_format($item->total_amount ,2)}}</td>
                                @php
                                    $total += $item->total_amount;

                                    $total_amount += $item->amount;

                                    $total_vat += $item->vat;

                                    $total_income_tax += $item->income_tax;
                                @endphp
                            </tr>

                        @endforeach
                        <tr>
                            <td style="text-align: right; font-weight: bold" colspan="7">সর্ব মোটঃ</td>
                            <td style="text-align: right; font-weight: bold">{{number_format($total_amount ,2)}}</td>
                            <td style="text-align: right; font-weight: bold">{{number_format($total_vat ,2)}}</td>
                            <td style="text-align: right;font-weight: bold">{{number_format($total_income_tax ,2)}}</td>
                            <td style="text-align: right; font-weight: bold">{{number_format($total ,2)}}</td>

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

