<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="nav-item ">

                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        @lang('message.dashboard') 
                    </a>

                </li>

                @if(\Illuminate\Support\Facades\Auth::user()->user_type == "system-admin")

                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('organization.index')  }}">
                            <i class="fas fa-user-plus"></i>
                            @lang('message.operator-list')
                        </a>

                    </li>
                    <!-- <li class="nav-item ">
                        <a class="nav-link" href="{{ route('designation.index')  }}"><i class="far fa-grin"></i>পদবী
                        </a>

                    </li> -->
                    <li class="nav-item ">
                        <a class="nav-link" href="javascript:void(0)">
                            <i class="fas fa-key"></i>
                            @lang('message.change-password')
                        </a>

                    </li>
                @else

                    <li class="menu-title">@lang('message.user')</li>

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('operator.index') }}">
                            <i class="fas fa-user-cog"></i>@lang('message.title')
                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('driver.index') }}">
                            <i class="fas fa-user-cog"></i>@lang('message.driver_title')
                        </a>

                    </li>


                    <li class="menu-title">গাড়ি</li>

                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('vehicle.index') }}">
                            <i class="fas fa-car-side"></i>
                            গাড়ি রেজিস্ট্রেশন
                        </a>

                    </li>


                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('vehicle.useless') }}"><i class="fas fa-car-crash"></i>অকেজো গাড়ি</a>

                    </li>
                    <li class="menu-title">কর্মকর্তা এবং ডাইভার</li>

                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('employee.index') }}"><i class="fas fa-users"></i>কর্মকর্তা
                        </a>

                    </li>
                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('driver.index') }}"><i class="fas fa-user-circle"></i>ড্রাইভার
                        </a>

                    </li>

                    <li class="menu-title">রিপোর্ট</li>

                    <li>
                        <a href="javascript: void(0);">
                            <i class="fe-clipboard"></i>
                            <span> রিপোর্ট </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level mm-collapse" aria-expanded="false" style="">
                            <li><a href="{{route('report.log_book')}}">
                                    লগ বই রিপোর্ট</a></li>
                        </ul>
                        <ul class="nav-second-level mm-collapse" aria-expanded="false" style="">
                            <li><a href="{{route('report.useless')}}">
                                    অকেজো গাড়ির রিপোর্ট</a></li>

                        </ul>
                        <ul class="nav-second-level mm-collapse" aria-expanded="false" style="">
                            <li><a href="{{route('report.lubricant')}}">
                                    লুব্রিক্যান্ট রিপোর্ট</a></li>

                        </ul>
                        <ul class="nav-second-level mm-collapse" aria-expanded="false" style="">
                            <li><a href="{{route('report.rentalcar')}}">
                                    ভাড়ায় গাড়ির রিপোর্ট</a></li>

                        </ul>
                        <ul class="nav-second-level mm-collapse" aria-expanded="false" style="">
                            <li><a href="{{route('report.repairs')}} ">
                                    যন্ত্রাংশ রিপোর্ট</a></li>

                        </ul>
                        <ul class="nav-second-level mm-collapse" aria-expanded="false" style="">
                            <li><a target="_blank" href="{{route('report.employee')}} ">কর্মকর্তার রিপোর্ট</a></li>

                        </ul>

                        <ul class="nav-second-level mm-collapse" aria-expanded="false" style="">
                            <li><a target="_blank" href="{{route('report.driver')}} ">
                                    ড্রাইভার রিপোর্ট</a></li>

                        </ul>

                    </li>


                    <li class="menu-title">সেটিং</li>

                    <li class="nav-item ">

                        <a class="nav-link" href="javascript:void(0)"><i class="fe-settings"></i>সেটিং</a>

                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('designation.index')  }}"><i class="far fa-grin"></i>পদবী
                        </a>

                    </li>
                @endif

                <li class="nav-item ">

                    <a class="nav-link" href="{{ route('trip.index') }}">
                        <i class="fas fa-car-side"></i>
                        Trip
                    </a>

                </li>

                <li class="nav-item ">

                    <a class="nav-link" href="{{ route('vehicle .index') }}">
                        <i class="fas fa-car-side"></i>
                        Vehicle 
                    </a>

                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
