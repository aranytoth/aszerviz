<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name', 'H2Off')}}</title>
     <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
    <link rel="stylesheet" href="/static/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/static/css/app.min.css" />
    <link rel="stylesheet" href="/static/css/icons.min.css" />
</head>
<body>
    <div id="layout-wrapper">
        @include('layouts._header')
        @include('layouts._menu')

        <div class="main-content">

            <div class="page-content">

                <div class="container-fluid pt-3">

                   @yield('content')
                </div>
            </div>
        @yield('content-footer')
        @include('layouts._footer')
        </div>
    
    </div>
    <script src="/static/libs/jquery/jquery.min.js"></script>
    <script src="/static/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/static/libs/node-waves/waves.min.js"></script>
    <script src="/static/libs/metismenu/metisMenu.min.js"></script>
    <script src="/static/js/app.js"></script>
    @yield('js')
</body>
</html>