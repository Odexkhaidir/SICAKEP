<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SICAKEP | Login </title>
    <link rel="icon" href="{{ url('') }}/dist/img/logo-sicakep.png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/global.js'])
</head>

<body class="hold-transition layout-fixed layout-footer-fixed">
    <!-- Navbar-->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-white py-3">
            <div class="container">
                <!-- Navbar Brand -->
                <a href="#" class="navbar-brand float-right">
                    <img src="{{ url('') }}/dist/img/logo-sicakep-h.png" alt="logo" width="150">
                </a>
            </div>
        </nav>
    </header>


    <div class="container">
        <div class="row py-5 mt-4 align-items-center">
            <!-- For Demo Purpose -->
            <div class="col-md-6 pr-lg-5 mb-5 mb-md-0">
                <img src="{{ url('') }}/dist/img/login-illustration.png" alt=""
                    class="img-fluid mb-3 d-none d-md-block">
                <h5 class="mb-0">Halo, Ayo Masuk ke Sicakep</h5>
                <p class="font-italic text-muted mb-0">Sistem Informasi Capaian Kinerja Instansi Pemerintah</p>
                <p class="font-italic text-muted">By <a href="https://sulut.bps.go.id">
                        <u>BPS Provinsi Sulawesi Utara</u></a>
                </p>
            </div>

            <!-- Registeration Form -->
            <div class="col-md-7 col-lg-6 ml-auto">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row">

                        {{-- <div class="form-group col-lg-10 mb-4">
                        <img src="{{url('')}}/dist/img/logo-sicakep-h.png" alt="" class="img-fluid mb-2 d-none d-md-block" width="300">
                    </div> --}}
                        <!-- First Name -->
                        <div class="input-group col-lg-10 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="username" type="username" name="username" placeholder="Username"
                                class="form-control bg-white border-left-0 border-md">
                        </div>

                        <!-- Password -->
                        <div class="input-group col-lg-10 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Password"
                                class="form-control bg-white border-left-0 border-md">
                        </div>

                        <div class="input-group col-lg-10 mb-4">

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked="checked" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                                </label>
                            </div>
                            <span class="ml-auto"><a href="{{route('password.request')}}" class="forgot-pass">Forgot
                                    Password</a></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-lg-10 mb-4">
                            <input type="submit" value="Log In" class="btn btn-primary btn-block py-2">
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="{{ url('') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('') }}/dist/js/adminlte.min.js"></script>
    <script src="{{ url('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ url('') }}/plugins/toastr/toastr.min.js"></script>

</body>

</html>
