<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon ">
{{--            <i class="fas fa-laugh-wink"></i>--}}
            <i class="fas fa-city"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Thuonghomes Riverside</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @php
        $url = Request::url();
    @endphp
    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if ($url === route('home')) active @endif">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (\Illuminate\Support\Facades\Auth::user()->status == 1)
        <!-- Heading -->
        {{--    <div class="sidebar-heading"> --}}
        {{--        Interface --}}
        {{--    </div> --}}

        <!-- Nav Item - Pages Collapse Menu -->
        {{--    <li class="nav-item"> --}}
        {{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" --}}
        {{--           aria-expanded="true" aria-controls="collapseTwo"> --}}
        {{--            <i class="fas fa-fw fa-cog"></i> --}}
        {{--            <span>Components</span> --}}
        {{--        </a> --}}
        {{--        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar"> --}}
        {{--            <div class="bg-white py-2 collapse-inner rounded"> --}}
        {{--                <h6 class="collapse-header">Custom Components:</h6> --}}
        {{--                <a class="collapse-item" href="buttons.html">Buttons</a> --}}
        {{--                <a class="collapse-item" href="cards.html">Cards</a> --}}
        {{--            </div> --}}
        {{--        </div> --}}
        {{--    </li> --}}

        <!-- Nav Item - Utilities Collapse Menu -->
        {{--    <li class="nav-item"> --}}
        {{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" --}}
        {{--           aria-expanded="true" aria-controls="collapseUtilities"> --}}
        {{--            <i class="fas fa-fw fa-wrench"></i> --}}
        {{--            <span>Utilities</span> --}}
        {{--        </a> --}}
        {{--        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" --}}
        {{--             data-parent="#accordionSidebar"> --}}
        {{--            <div class="bg-white py-2 collapse-inner rounded"> --}}
        {{--                <h6 class="collapse-header">Custom Utilities:</h6> --}}
        {{--                <a class="collapse-item" href="utilities-color.html">Colors</a> --}}
        {{--                <a class="collapse-item" href="utilities-border.html">Borders</a> --}}
        {{--                <a class="collapse-item" href="utilities-animation.html">Animations</a> --}}
        {{--                <a class="collapse-item" href="utilities-other.html">Other</a> --}}
        {{--            </div> --}}
        {{--        </div> --}}
        {{--    </li> --}}

        <!-- Divider -->
        {{--    <hr class="sidebar-divider"> --}}

        <!-- Heading -->
        {{--    <div class="sidebar-heading"> --}}
        {{--        Addons --}}
        {{--    </div> --}}

        <!-- Nav Item - Pages Collapse Menu -->
        {{--    <li class="nav-item"> --}}
        {{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" --}}
        {{--           aria-expanded="true" aria-controls="collapsePages"> --}}
        {{--            <i class="fas fa-fw fa-folder"></i> --}}
        {{--            <span>Pages</span> --}}
        {{--        </a> --}}
        {{--        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar"> --}}
        {{--            <div class="bg-white py-2 collapse-inner rounded"> --}}
        {{--                <h6 class="collapse-header">Login Screens:</h6> --}}
        {{--                <a class="collapse-item" href="login.html">Login</a> --}}
        {{--                <a class="collapse-item" href="register.html">Register</a> --}}
        {{--                <a class="collapse-item" href="forgot-password.html">Forgot Password</a> --}}
        {{--                <div class="collapse-divider"></div> --}}
        {{--                <h6 class="collapse-header">Other Pages:</h6> --}}
        {{--                <a class="collapse-item" href="404.html">404 Page</a> --}}
        {{--                <a class="collapse-item" href="blank.html">Blank Page</a> --}}
        {{--            </div> --}}
        {{--        </div> --}}
        {{--    </li> --}}

        <!-- Nav Item - Charts -->
        {{--    <li class="nav-item"> --}}
        {{--        <a class="nav-link" href="charts.html"> --}}
        {{--            <i class="fas fa-fw fa-chart-area"></i> --}}
        {{--            <span>Charts</span></a> --}}
        {{--    </li> --}}

        <!-- Nav Item - Tables -->
        {{--    <li class="nav-item"> --}}
        {{--        <a class="nav-link" href="tables.html"> --}}
        {{--            <i class="fas fa-fw fa-table"></i> --}}
        {{--            <span>Tables</span></a> --}}
        {{--    </li> --}}

        @can('list_building')
            <li class="nav-item @if ($url === route('building.index')) active @endif">
                <a class="nav-link" href="{{ route('building.index') }}">
{{--                    <i class="far fa-building"></i>--}}
                    <i class="fas fa-home"></i>
                    <span>Houses</span></a>
            </li>
        @endcan

        @can('list_role')
            <li class="nav-item @if ($url === route('role.index')) active @endif">
                <a class="nav-link" href="{{ route('role.index') }}">
                    <i class="fas fa-user-lock"></i>
                    <span>Roles</span></a>
            </li>
        @endcan
        @can('list_user')
        <li class="nav-item @if ($url === route('user.index') || $url === route('user.create')) active @endif">
            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true"
                aria-controls="collapseUtilities1">
                <i class="fas fa-users"></i>
                <span>Users</span></a>
            <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Action:</h6>
                    <a class="collapse-item" @can('list_user') href="{{ route('user.index') }}" @endcan>List User</a>
                    @if (\Illuminate\Support\Facades\Auth::user()->own_id == 0)
                        <a class="collapse-item" @can('create_user') href="{{ route('user.create') }}" @endcan>Create
                            User</a>
                    @endif
                </div>
            </div>
        </li>
        @endcan
        @can('list_qrcode')
        <li class="nav-item @if ($url === route('qr.index') || $url === route('qr.create')) active @endif">
            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true"
                aria-controls="collapseUtilities">
                <i class="fas fa-qrcode"></i>
                <span>QrCodes</span></a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Action:</h6>

                    <a class="collapse-item" @can('list_qrcode') href="{{ route('qr.index') }}" @endcan>List QrCode</a>
                    <a class="collapse-item" @can('create_qrcode') href="{{ route('qr.create') }}" @endcan>Create
                        QrCode</a>
                </div>
            </div>
        </li>
        @endcan
        @can('check_qrcode')
            <li class="nav-item @if ($url === route('qr.checkForm')) active @endif">
                <a class="nav-link" href="{{ route('qr.checkForm') }}">
                    <i class="fas fa-check-square"></i>
                    <span>Check QrCodes</span></a>
            </li>
        @endcan
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="{{ route('notification.index') }}">--}}
{{--                <i class="fas fa-bell"></i>--}}
{{--                <span>Notifications</span></a>--}}
{{--        </li>--}}
        @can('history_event')
        <li class="nav-item">
            <a class="nav-link" href="{{route('history.index')}}">
                <i class="fas fa-history"></i>
                <span>History</span></a>
        </li>
        @endcan
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>
