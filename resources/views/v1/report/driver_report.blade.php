<html>

<head>

    <title>Driver Report</title>
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
        <table  style="font-size:12px;" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td colspan="4">
                    <table  border="0" cellpadding="0" cellspacing="0" width="100%">
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

                                    <tr>
                                        <td width="100%" align="center"></td>
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
                <td style="height: 30px"></td>
            </tr>

            <tr>
                <td style="text-align: center;">
                    <h2 style="text-decoration: underline;">ড্রাইভার রিপোর্ট </h2>

                </td>
            </tr>

            <tr>
                <td height='4' colspan="4">
                    <p style="text-align: center;font-size: 18px;">

                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="tbl_style" cellpadding="2" style="border-collapse:collapse;">

                        <tr style="font-weight: bold;">

                            <td>নং</td>
                            {{--                            <td>ছবি</td>--}}
                            <td>নাম</td>
                            <td>গাড়ির নং</td>
                            <td>মোবাইল নং</td>


                        </tr>
                        @php
                            $key = 0;
                        @endphp
                        @foreach($driver_info as $item)
                            <tr>
                                <td>{{++$key}}</td>
                                {{--                            <td><img style="float: right;" src="{{ asset('storage/app/public/employees/$item->image') }}"--}}
                                {{--                                     id="hide"--}}
                                {{--                                     height="50" width="50"></td>--}}
                                <td>{{$item->name}}</td>
                                <td>{{$item->vehicle_reg_no}}</td>
                                <td>{{$item->mobile_no}}</td>
{{--                                <td>{{$item->email}}</td>--}}
                            </tr>

                        @endforeach

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
