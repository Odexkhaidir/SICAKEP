<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Top Navigation</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ url('') }}/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="{{ url('') }}/dist/css/adminlte.min.css?v=3.2.0">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/global.js'])
    
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand-md navbar-dark navbar-purple">
            <div class="container col-9">
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                    <ul class="navbar-nav">
                        
                        <li class="nav-item">
                            <a href="index3.html" class="nav-link">Home</a>
                        </li>
                        
                    </ul>

                    <form class="form-inline ml-0 ml-md-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">


                    <li class="nav-item">
                        <a href="/evaluation/create" class="btn btn-outline-light me-2" style='margin-right:10px'>
                            Log In</a>
                    </li>
                
                </ul>
            </div>
        </nav>

        <div class="content-wrapper">

            <div class="content">
                <div class="container">
                    <div class="row">
                        
                    </div>

                </div>
            </div>

        </div>


    </div>



    <script src="{{ url('') }}/plugins/jquery/jquery.min.js"></script>

    <script src="{{ url('') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="{{ url('') }}/dist/js/adminlte.min.js?v=3.2.0"></script>

    <script src="{{ url('') }}/dist/js/demo.js"></script>
</body>

</html>
