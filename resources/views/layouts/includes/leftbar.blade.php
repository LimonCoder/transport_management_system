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

                @if(Auth::user()->user_type == "system-admin")

                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('organizations.index')  }}">
                            <i class="fas fa-building"></i>
                            @lang('message.organisation')
                        </a>

                    </li>
                     <li class="nav-item ">
                        <a class="nav-link" href="{{ route('designation.index')  }}"><i class="far fa-grin"></i>
                            @lang('message.designation')
                        </a>

                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('designation.index')  }}"><i class="far fa-grin"></i>
                            @lang('message.settings')
                        </a>

                    </li>

                @elseif(Auth::user()->user_type == 'operator')

                    @if(Auth::user()->is_special_user == 1)
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('operator.index')  }}">
                                <i class="fas fa-user-plus"></i>
                                @lang('message.operator-list')
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('notice.index')  }}">
                                <i class="fas fa-user-plus"></i>
                                @lang('message.notice-list')
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('driver.index') }}">
                            <i class="fas fa-user-cog"></i>@lang('message.driver_title')
                        </a>

                    </li>
                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('trip.index') }}">
                            <i class="fas fa-car-side"></i>
                            @lang('message.trip')
                        </a>

                    </li>
                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('vehicle.index') }}">
                            <i class="fas fa-car-side"></i>
                            @lang('message.vehicle')
                        </a>

                    </li>
                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('routes.index') }}">
                            <i class="fas fa-car-side"></i>
                            @lang('message.route')
                        </a>

                    </li>
                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('trip.report') }}">
                            <i class="fas fa-car-side"></i>
                            @lang('message.trip-report')
                        </a>

                    </li>
                @elseif(Auth::user()->user_type == 'driver')
                    <li class="nav-item ">

                        <a class="nav-link" href="{{ route('trip.details') }}">
                            <i class="fas fa-clipboard-list"></i>
                            @lang('message.trip-list')
                        </a>

                    </li>
                @endif
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
