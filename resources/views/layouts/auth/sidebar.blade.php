<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home') }}">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            @if(Auth::user()->hasRole(\App\Role\UserRole::ROLE_ADMIN))
            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle @section('user_nav_link') @show">
                    <i class="nav-icon far fa-user"></i> User Control
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/users') }}">
                            <i class="nav-icon fa fa-user-friends"></i> Registered Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/users/add') }}">
                            <i class="nav-icon fa fa-user-plus"></i> Add User
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if (Auth::user()->hasRole(\App\Role\UserRole::ROLE_AUTHOR))
            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle @section('article_nav_link') @show">
                    <i class="nav-icon far fa-newspaper"></i> Newsletters
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/articles') }}">
                            <i class="nav-icon fa fa-book-reader"></i> View Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/articles/add') }}">
                            <i class="nav-icon fa fa-file-upload"></i> Publish
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            
            <li class="nav-item mt-auto">
                <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon cui-account-logout"></i> Logout</a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>