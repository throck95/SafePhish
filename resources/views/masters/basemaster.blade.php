<html>
    <head>
        <title>@yield('title')</title>
        @yield('csrf_token')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        @yield('scripts')
        <script type="text/javascript" src="/js/navBar.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="/css/basicstyles.css" />
        @yield('formcss')
        <link rel="stylesheet" type="text/css" href="/css/navBar.css" />
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        @yield('stylesheets')
    </head>
    <body>
        <div class="rootContainer">
            @include('includes.navBar_include')
            @yield('contentViewer')
            @yield('bodyContent')
        </div>
        <footer>
            @yield('footer')
            <div id="idleTime"></div>
        </footer>
    </body>
</html>