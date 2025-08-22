<nav class="main-header navbar navbar-expand navbar-dark gradient-custom" style="background-color:#2E95CA; border-color:#2E95CA">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ url('') }}/dist/img/avatar.png" width="30" height="30" class="rounded-circle">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user mx-1"></i> Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item" href=""><i class="nav-icon fas fa-sign-out-alt"></i>
                        Log Out</button>
                </form>
            </div>
        </li>
    </ul>
</nav>
