<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">





        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ asset('/assets/images/user_demo.png') }}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                                {{ \Illuminate\Support\Facades\Auth::user()->username  }} <i class="mdi
                                mdi-chevron-down"></i>
                            </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>প্রোফাইল</span>
                </a>

                <!-- item-->
                <a href="{{ route('impersonate.leave') }}" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>লগআউট</span>
                </a>

            </div>
        </li>




    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="javescript:void(0)" class="logo logo-dark text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('/assets/images/logo.png') }}" alt="" height="16" style="width: 53%;height: 71%;">
                        </span>
            <span class="logo-sm">
                            <img src="{{ asset('/assets/images/logo.png') }}" alt="" height="24">
                        </span>
        </a>
        <a href="index.html" class="logo logo-light text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('/assets/images/logo.png') }}" alt="" height="16">
                        </span>
            <span class="logo-sm">
                            <img src="{{ asset('/assets/images/logo.png') }}" alt="" height="24">
                        </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <h4 class="page-title-main" style="text-align: center">{{ (\Illuminate\Support\Facades\Auth::user()->type
            != 1)?\App\helpers\GlobalHelper::getOrganizationInfo()
            ->name : ''  }}</h4>
        </li>

    </ul>

</div>
