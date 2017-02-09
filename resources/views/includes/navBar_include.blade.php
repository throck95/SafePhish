<header>
    <div id="headerBar">
        @if(\Session::get('authUser'))
            <a class="authenticationLink" href="/user/update">MY ACCOUNT</a>
            <a class="authenticationLink" href="/logout">LOGOUT</a>
        @else
            <a class="authenticationLink" href="/login">LOGIN</a>
        @endif
    </div>
    <div id="logoBar">
        <a href="/">
            <img id="spHeadLogo" src="/images/logos/safephish_logo.png" />
        </a>
    </div>
    @yield('header')
</header>
<div id="navBar">
    @if(\Session::get('authUser') || \Session::get('adminUser'))
        <ul>
            <li class="dropdown">
                <a class="dropbtn">Reports</a>
                <div class="navbar-dropdown">
                    <a href="/reports/web">Web</a>
                    <a href="/reports/email">Email</a>
                </div>
            </li>
            <li class="dropdown">
                <a class="dropbtn">Campaigns</a>
                <div class="navbar-dropdown">
                    <a href="/campaigns">Display</a>
                    <a href="/campaign/create">New</a>
                </div>
            </li>
            <li class="dropdown">
                <a class="dropbtn">Templates</a>
                <div class="navbar-dropdown">
                    <a href="/templates">Display</a>
                </div>
            </li>
            <li class="dropdown">
                <a class="dropbtn">Mailing Lists</a>
                <div class="navbar-dropdown">
                    <a href="/mailinglist/users">Manage</a>
                    <a href="/mailinglist/groups">Groups</a>
                    <a href="/mailinglist/create/user">New User</a>
                    <a href="/mailinglist/create/group">New Group</a>
                </div>
            </li>
            @if(\Session::get('adminUser'))
                <li class="dropdown">
                    <a class="dropbtn">Users</a>
                    <div class="navbar-dropdown">
                        <a href="/users">Manage</a>
                        <a href="/register">Register</a>
                    </div>
                </li>
            @endif
        </ul>
    @endif
</div>