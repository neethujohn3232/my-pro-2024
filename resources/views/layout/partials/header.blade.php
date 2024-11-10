<div class="main-wrapper">
	
    <!-- Header -->
    <div class="header">
        <div class="header-left"> 
            <a href="index" class="logo logo-small">
                <img src="assets/img/logo-icon.png" alt="Logo" width="30" height="30">
            </a>
        </div>
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-align-left"></i>
        </a>
        <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
            <i class="fas fa-align-left"></i>
        </a>
        
        <ul class="nav user-menu">
            <!-- Notifications -->
           
            <!-- /Notifications -->
            
            <!-- User Menu -->
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
                    <span class="user-img">
                        <img class="rounded-circle" src="assets/logo.jpg" width="40" alt="Admin">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    {{-- <a class="dropdown-item" href="admin-profile">Profile</a>
                    <a class="dropdown-item" href="{{ url('logout')}}">Logout</a> --}}
                    {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> --}}
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    {{-- </div> --}}
                </div>
            </li>
            <!-- /User Menu -->
            
        </ul>
    </div>
    <!-- /Header -->