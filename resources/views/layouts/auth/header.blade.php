<header class="app-header navbar fixed-top py-0 px-sm-5">
    @auth
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto btn-outline-light" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand text-dark pl-md-5" href="{{ url('/home') }}">
        {{config('app.name', 'Pondong Batangan')}}
    </a> @endauth @auth
    <ul class="nav navbar-nav ml-auto mr-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" id="navbarDropdown" aria-haspopup="true"
                aria-expanded="false">
                <span class="d-md-inline d-none">Hi {{Auth::user()->user_profile->salutation.' '.Auth::user()->user_profile->first_name}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow mt-2" aria-labelledby="navbarDropdown">
                <a class="dropdown-item">
                    <img src="{{ 'storage/profile_images/'.Auth::user()->user_profile->profile_image_tmb }}" height="50" class="mr-2">
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </a>
                <a class="dropdown-item @section('profile_nav_link') @show" href="{{ url('/users/'.Auth::user()->user_profile->id.'/view') }}">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
    @endauth
</header>