<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> TMS | @yield('title')</title>
    <meta name="path" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="Vehicle managment software" name="Vehicle managment softwar software is easy to keep track of the vehicles of government establishments." />
    <meta name="author" content="innovation it">
    <meta name="robots" content="noindex, nofollow">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.ico')  }}">


    <!-- third party css -->
    <link href="{{ asset('/assets/libs/datatables/dataTables.bootstrap4.css')  }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->



    <!-- Sweet Alert-->
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css')  }}" rel="stylesheet" type="text/css" />
    
    <!-- Toastr CSS -->
    <link href="{{ asset('/assets/libs/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    <!-- Font Css -->
    <link href="{{ asset('https://fonts.maateen.me/solaiman-lipi/font.css') }}" rel="stylesheet">

    <!-- DatePicker -->
    <link rel="stylesheet" href="{{ asset('/assets/libs/datepicker/date-picker-ui.css') }}">

    <!-- Time Picker -->
    <link href="{{ asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'SolaimanLipi', Roboto, sans-serif !important;
            font-size: 14px;
        }
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6{
            font-family: 'SolaimanLipi', Roboto, sans-serif !important;
        }
    </style>

    @yield('css')

</head>

<body>

<!-- Begin page -->
<div id="wrapper">
{{-- <div class="gtranslate_wrapper"></div> --}}
    <!-- Topbar Start -->
   @include('layouts.includes.topbar')
    <!-- end Topbar -->

    <!-- Left Sidebar Start -->
   @include('layouts.includes.leftbar')
    <!-- Left Sidebar End -->


    <div class="content-page">
        <!--  Main-content -->
        @yield('main-content')
        <!--  Main-content -->


        <!-- Footer Start -->
        @include('layouts.includes.footer')
        <!-- end Footer -->

    </div>



</div>
<!-- END wrapper -->
<!-- Auth type  -->
<input type="hidden" name="auth_type" id="auth_type" value="{{ \Illuminate\Support\Facades\Auth::user()->type }}" >

<!-- Vendor js -->
<script src="{{ asset('/assets/js/vendor.min.js')  }}"></script>


<!-- third party js -->
<script src="{{ asset('/assets/libs/datatables/jquery.dataTables.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/dataTables.bootstrap4.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/dataTables.responsive.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/responsive.bootstrap4.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/dataTables.buttons.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/buttons.bootstrap4.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/buttons.html5.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/buttons.flash.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/buttons.print.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/dataTables.keyTable.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/datatables/dataTables.select.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/pdfmake/pdfmake.min.js')  }}"></script>
<script src="{{ asset('/assets/libs/pdfmake/vfs_fonts.js')  }}"></script>
<!-- third party js ends -->

<!-- Sweet Alerts js -->
<script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Toastr js -->
<script src="{{ asset('/assets/libs/toastr/toastr.min.js') }}"></script>







<!-- App js -->
<script src="{{ asset('/assets/js/app.min.js') }}"></script>

<!-- parsly js -->
<script src="{{ asset('/assets/libs/parsleyjs/parsley.min.js') }}"></script>



<!-- datepicker js -->
<script src="{{ asset('/assets/libs/datepicker/datepicker-ui.js') }}"></script>

<!-- Time Picker js -->
<script src="{{ asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>




{{-- <script>window.gtranslateSettings = {"default_language":"en","languages":["en","fr","it","de","bn","ar","hi"],"wrapper_selector":".gtranslate_wrapper","switcher_horizontal_position":"right"}</script>
<script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script> --}}

<!-- Custom js -->
<script src="{{ asset('/assets/js/custom/v1/custom.js') }}"></script>

<!-- Notifications Script (loaded after jQuery) -->
<script src="{{ asset('/assets/js/custom/notifications.js') }}"></script>

@yield('js')

</body>
</html>
