<div class="left side-menu">

    <div class="slimscroll-menu" id="remove-scroll">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="index.html" class="logo">
                <span>
                    <img src="{{ asset('backend') }}/images/logo.png" alt="" height="22">
                </span>
                <i>
                    <img src="{{ asset('backend') }}/images/logo_sm.png" alt="" height="28">
                </i>
            </a>
        </div>

        <!-- User box -->
        <div class="user-box">
            <div class="user-img">
                <img src="{{ asset('backend') }}/images/users/avatar-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
            </div>
            <h5><a href="#">{{ Auth::user()->name }}</a> </h5>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <!--<li class="menu-title">Navigation</li>-->

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fi-air-play"></i><span class="badge badge-danger badge-pill pull-right">1</span> <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.list') }}">
                        <i class="fi-command"></i> <span> User List </span>
                    </a>
                </li>

                <li class="menu-title">More</li>

            </ul>

        </div>
        <!-- Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>