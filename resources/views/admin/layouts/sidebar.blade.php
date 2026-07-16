<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
                        
                        
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->user()->avatar ?? 'default/avatar.png') }}" class="rounded-circle mr-1">
                <div class="d-none d-md-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
              
                <div class="dropdown-divider"></div>
    {{-- Clear Cache --}}
    {{-- <form method="POST" action="{{ route('admin.clear.cache') }}">
        @csrf
        <button type="submit" class="dropdown-item has-icon text-warning">
            <i class="fas fa-broom"></i> Clear Cache
        </button>
    </form> --}}

    {{-- Optimize Clear --}}
    {{-- <form method="POST" action="{{ route('admin.optimize.clear') }}">
        @csrf
        <button type="submit" class="dropdown-item has-icon text-info">
            <i class="fas fa-sync-alt"></i> Optimize Clear
        </button>
    </form> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
 
        <ul class="sidebar-menu">

            <li class="menu-header">Starter</li>
            <li class="{{ setSidebarActive(['admin.dashboard.index']) }}"><a class="nav-link"
                    href="{{ route('admin.dashboard.index') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
         


            

        </ul>
    </aside>
</div>