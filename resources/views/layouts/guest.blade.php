<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} </title>
    <link rel="icon" href="{{ url('') }}/dist/img/logo-sicakep.png">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ url('') }}/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="{{ url('') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="{{ url('') }}/dist/css/adminlte.min.css?v=3.2.0">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/global.js'])
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ url('') }}/dist/img/logo-sicakep-h.png" alt="logo" width="150">
        </div>

        {{ $slot }}
    </div>


    <script src="{{ url('') }}/plugins/jquery/jquery.min.js"></script>

    <script src="{{ url('') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="{{ url('') }}/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>
