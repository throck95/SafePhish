<header>
    <div id="headerBar">
        @if(\Session::get('authUser'))
            <a class="authenticationLink" target="_blank" href="#">MY ACCOUNT</a>
            <a class="authenticationLink" href="/logout">LOGOUT</a>
        @else
            <a class="authenticationLink" href="/login">LOGIN</a>
        @endif
    </div>
    <div id="logoBar">
        <a target="_blank" href="#">
            <img id="spHeadLogo" src="/images/logos/safephish_logo_v1.png" />
        </a>
    </div>
    @yield('header')
</header>
<div id="navBar">
    @if(\Session::get('authUser') || \Session::get('adminUser'))
        <ul>
            <li class="dropdown">
                <a href="#reports" class="dropbtn">Reports</a>
                <div class="navbar-dropdown">
                    <a href="#reports_web">Web</a>
                    <a href="#reports_email">Email</a>
                </div>
            </li>
            <li><a href="#campaigns">Campaigns</a></li>
            <li><a href="#templates">Templates</a></li>
            <li class="dropdown">
                <a href="#mlu" class="dropbtn">Mailing Lists</a>
                <div class="navbar-dropdown">
                    <a href="#mlu_manage">Manage</a>
                    <a href="#mlu_groups">Groups</a>
                </div>
            </li>
            @if(\Session::get('adminUser'))
                <li><a href="#users">Users</a></li>
            @endif
        </ul>
    @endif
</div>