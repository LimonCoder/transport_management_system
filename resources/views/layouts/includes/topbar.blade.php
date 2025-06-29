<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        @if(Auth::user()->user_type == "driver")
        <!-- Notifications -->
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" id="notification-bell">
                <div class="notification-icon-wrapper">
                    <i class="fe-bell noti-icon"></i>
                </div>
                <span class="noti-icon-badge" id="notification-badge" style="display: none; top: 37px;right: 3px"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right notification-list dropdown-lg">
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">
                            <a href="#" class="text-dark" id="clear-all-notifications">
                                <small>@lang('message.clear_all')</small>
                            </a>
                        </span>@lang('message.notifications')
                    </h5>
                </div>

                <div class="noti-scroll" data-simplebar>
                    <div id="notifications-container">
                        <!-- Notifications will be loaded here -->
                        <div class="text-center p-3" id="no-notifications">
                            <small class="text-muted">@lang('message.no_notifications')</small>
                        </div>
                    </div>
                </div>

                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                    @lang('message.view_all')
                </a>
            </div>
        </li>
        @endif


        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button">
                🌐 <span class="ml-1">{{ strtoupper(session('locale', 'en')) }} <i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                <a href="{{ url('lang/en') }}" class="dropdown-item notify-item {{ session('locale') == 'en' ? 'active' : '' }}">
                    English
                </a>
                <a href="{{ url('lang/bn') }}" class="dropdown-item notify-item {{ session('locale') == 'bn' ? 'active' : '' }}">
                    বাংলা
                </a>
            </div>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ asset('/assets/images/user_demo.png') }}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    {{ \Illuminate\Support\Facades\Auth::user()->username  }}
                    <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>@lang('message.profile')</span>

                </a>

                <!-- item-->
                <a href="{{ route('impersonate.leave') }}" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>@lang('message.logout')</span>
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
        <h4 class="page-title-main" style="text-align: center">@lang('message.' . auth()->user()->username)</h4>

        </li>

    </ul>

</div>

<!-- Notification Styles -->
<style>
.notification-item {
    padding: 12px 20px;
    border-bottom: 1px solid #f1f3f4;
    cursor: pointer;
    position: relative;
    transition: background-color 0.2s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background-color: #f0f8ff;
    border-left: 3px solid #007bff;
}

.notification-item .notify-icon {
    float: left;
    height: 36px;
    width: 36px;
    font-size: 16px;
    line-height: 36px;
    text-align: center;
    margin-right: 12px;
    border-radius: 50%;
    color: #fff;
}

.notification-item .notify-details {
    margin-left: 48px;
}

.notification-item .notify-details strong {
    display: block;
    margin-bottom: 4px;
    color: #343a40;
}

.notification-item .notify-details p {
    margin-bottom: 4px;
    color: #6c757d;
    font-size: 14px;
}

.notification-item .unread-indicator {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}

.noti-icon-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff5b5b;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    line-height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

/* Circular notification icon wrapper */
.notification-icon-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background-color: #6c757d;
    border-radius: 50%;
    transition: background-color 0.3s ease;
}

.notification-icon-wrapper:hover {
    background-color: #495057;
}

.notification-icon-wrapper .noti-icon {
    color: #fff;
    font-size: 16px;
    margin: 0;
}

/* Notification bell animation for new notifications */
#notification-bell.notification-new .notification-icon-wrapper {
    animation: bellShake 0.5s ease-in-out 3;
    background-color: #ff5b5b;
}

#notification-bell.notification-new .notification-icon-wrapper .fe-bell {
    color: #fff !important;
}

@keyframes bellShake {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-10deg); }
    75% { transform: rotate(10deg); }
}

/* Notification pulse effect */
.noti-icon-badge.pulse {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.dropdown-lg {
    width: 350px;
    max-width: 350px;
}

@media (max-width: 768px) {
    .dropdown-lg {
        width: 300px;
        max-width: 300px;
    }
}
</style>

<!-- Include notification script -->
<script>
   
</script>
