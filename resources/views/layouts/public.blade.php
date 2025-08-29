<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        @yield('content')
    <style>
        .container {
            width: 1000px;
            margin: 0 auto;
        }
        .container #title span {
            position: relative;
            margin-top: 8px;
        }
        .worksheet-signals {
            margin-top: 30px;
            width: 100%;
        }
        .worksheet-signals div {
            width: 40%;
        }
    </style>
    </div>
</body>
</html>