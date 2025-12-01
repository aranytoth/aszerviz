<!DOCTYPE html>
<html lang="hu">
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
    @livewireStyles
    @yield('css')
</head>
<body>
    <div id="layout-wrapper">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <script src="/static/libs/jquery/jquery.min.js"></script>
    <script src="/static/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
    @yield('js')
</body>
</html>