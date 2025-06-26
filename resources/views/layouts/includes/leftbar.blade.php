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
                @endif

                <li class="nav-item ">

                    <a class="nav-link" href="{{ route('trip.index') }}">
                        <i class="fas fa-car-side"></i>
                        Trip
                    </a>

                </li>

                <li class="nav-item ">

                    <a class="nav-link" href="{{ route('vehicle.index') }}">
                        <i class="fas fa-car-side"></i>
                        Vehicle 
                    </a>

                </li>

                <li class="nav-item ">

                    <a class="nav-link" href="{{ route('trip.report') }}">
                        <i class="fas fa-car-side"></i>
                        Trip Report
                    </a>

                </li>
            
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
