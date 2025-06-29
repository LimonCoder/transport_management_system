<html>

<head>

    <title>LogBook Report</title>
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
                            <td valign='top'><img style="height: 70px; width: 80px" src="{{asset
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
                <td style="text-align: center;" colspan="4">
                    <h2 style="text-decoration: underline; margin-top: 10px">
                        লগ বইয়ের রিপোর্ট
                    </h2>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="tbl_style" cellpadding="2" style="border-collapse:collapse;">
                        <thead>
                        <tr>
                            <th rowspan="2">তারিখ</th>
                            <th rowspan="2">ফরমাশ দাতার নাম ও পদবী</th>
                            <th rowspan="2">হইতে</th>
                            <th rowspan="2">বাহির হইবার সময়</th>
                            <th rowspan="2">গন্তব্য স্থান</th>
                            <th rowspan="2">ভ্রমন করিবার সময়</th>
                            <th rowspan="2">গাড়ি ব্যাবহারের কারন</th>

                            <th colspan="3">মাইল মিটার</th>

                            <th rowspan="2">গাড়ি ব্যাবহার কারীর দস্তখত,ছাড়ার সময় ও তারিখ</th>
                            <th colspan="4">লুব্রিক্যান্ট</th>
                            <th rowspan="2">মন্তব্য</th>
                        </tr>

                        <tr>
                            <td>যাওয়ার সময়</td>
                            <td>আসার সময়</td>
                            <td>মোট সময়</td>
                            <td>পূর্বের জমা</td>
                            <td>সরবারহ</td>
                            <td>খরচ</td>
                            <td>মজুদ</td>
                        </tr>

                        </thead>
                        <tbody>
                        @foreach($log_book_data as $key=> $item)
                            <tr>
                                <td width="7%">{{date('d-m-Y',strtotime($item->insert_date))}}</td>
                                <td width="13%">{{$item->employee_name}}({{$item->designation_name}})</td>
                                <td>{{$item->from}}</td>
                                <td>{{$item->out_time}}</td>
                                <td>{{$item->destination}}</td>
                                <td>{{$item->journey_time}}</td>
                                <td width="15%">{{$item->journey_cause}}</td>
                                <td>{{$item->out_time}}</td>
                                <td>{{$item->in_time}}</td>
                                <td>{{$item->journey_time}}</td>
                                <td width="10%"></td>
                                <td>{{$item->previous_stock}}</td>
                                <td>{{$item->in}}</td>
                                <td>{{$item->out}}</td>
                                <td>{{$item->total_stock}}</td>
                                <td></td>

                            </tr>
                            @php
                                if (($key+1) % 10 == 0 && count($log_book_data) > $key+1):
                            echo '</tbody>
                    </table>

                </td>
            </tr>

            <tr>
                <td colspan="4" style="height:40px;"></td>
            </tr>
        </table>
        <table style="border-collapse:collapse;table-layout:fixed;margin:0px auto;" width="99%" height="215px"
               cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
                <td style="padding-left:20px;font-size:16px !important;box-sizing: border-box;
                -moz-box-sizing:border-box;-webkit-box-sizing:border-box;
"><b>নির্দেশাবলীঃ </b><br><br>১) ৫নং কলামে গাড়ী ব্যাবহারকারীর প্রতিটি ভ্রমণ লিপিবদ্ধ করিবেন।<br><br>২) ভ্রমণের কারন
                    বিশেষভাবে উল্লেখ করিবেন,কেবল সরকারী কাজ উল্লেখ করিলেই যথেষ্ট নহে।
                    <br><br>
                    ৩) ১১ নং কলামে গাড়ী ব্যাবহারকারী তাহার পদবী,তারিখ এবং গাড়ী ছাড়িবার সময়সহ দস্থখত করিবেন।
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</div><div class="wrapper" attr="none">
    <div class="jolchap">
        <table style="font-size:12px;" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td colspan="4">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td valign="top"><img style="float:right; height: 70px; width: 80px" src="'.@asset
                            ('/assets/images/feni_pou.png').'" class="logo pull-right"/></td>
                            <td width="60%">
                                <table class="table" width="100%;" border="0" cellpadding="0" cellpadding="0"
                                       style="border-collapse:collapse;line-height: 1.3">
                                    <tr>
                                        <td width="100%" align="center">
                                            <p
                                                style="font-size:25px;font-weight:bold; text-align:center;padding:
                                                5px">' .@$org->name.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100%" align="center">
                                                <span style="font-size:16px; font-weight:normal;text-align:center;">'
                                                   .@$org->address.
                                                '</span>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                            <td width="20%" style="padding-top:0px;">
                            <img style="height: 70px; width: 117px" src="'.@asset
                            ('/assets/images/.png').'" class="logo pull-right"/>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="4">
                    <h2 style="text-decoration: underline; margin-top: 10px">
                        লগ বইয়ের রিপোর্ট
                    </h2>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="tbl_style" cellpadding="2" style="border-collapse:collapse;">
                        <thead>
                        <tr>
                            <th rowspan="2">তারিখ</th>
                            <th rowspan="2">ফরমাশ দাতার নাম ও পদবী</th>
                            <th rowspan="2">হইতে</th>
                            <th rowspan="2">বাহির হইবার সময়</th>
                            <th rowspan="2">গন্তব্য স্থান</th>
                            <th rowspan="2">ভ্রমন করিবার সময়</th>
                            <th rowspan="2">গাড়ি ব্যাবহারের কারন</th>

                            <th colspan="3">মাইল মিটার</th>

                            <th rowspan="2">গাড়ি ব্যাবহার কারীর দস্তখত,ছাড়ার সময় ও তারিখ</th>
                            <th colspan="4">লুব্রিক্যান্ট</th>
                            <th rowspan="2">মন্তব্য</th>
                        </tr>

                        <tr>
                            <td>যাওয়ার সময়</td>
                            <td>আসার সময়</td>
                            <td>মোট সময়</td>
                            <td>পূর্বের জমা</td>
                            <td>সরবারহ</td>
                            <td>খরচ</td>
                            <td>মজুদ</td>
                        </tr>';
                            endif;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>

                </td>
            </tr>

            <tr>
                <td colspan="4" style="height:40px;"></td>
            </tr>
        </table>
        <table style="border-collapse:collapse;table-layout:fixed;margin:0px auto;" width="99%" height="215px"
               cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
                <td style="padding-left:20px;font-size:16px !important;box-sizing: border-box;
                -moz-box-sizing:border-box;-webkit-box-sizing:border-box;
"><b>নির্দেশাবলীঃ </b><br><br>১) ৫নং কলামে গাড়ী ব্যাবহারকারীর প্রতিটি ভ্রমণ লিপিবদ্ধ করিবেন।<br><br>২) ভ্রমণের কারন
                    বিশেষভাবে উল্লেখ করিবেন,কেবল সরকারী কাজ উল্লেখ করিলেই যথেষ্ট নহে।
                    <br><br>
                    ৩) ১১ নং কলামে গাড়ী ব্যাবহারকারী তাহার পদবী,তারিখ এবং গাড়ী ছাড়িবার সময়সহ দস্থখত করিবেন।
                </td>
            </tr>

            </tbody>
        </table>
    </div>

</div>

</body>

</html>

