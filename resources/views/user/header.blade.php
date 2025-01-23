<header>
    <div class="container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="{{ asset('assets/images/logo/nuansa_fix.png')}}" alt="Logo">
        </div>

        <!-- Navigation Menu (Centered) -->
        <nav>
            <ul id="navbar" >

                <li><a href="{{ url('') }}">Beranda</a></li>
                <li><a href="{{ url('halaman-buku') }}" >Buku</a></li>
                <li><a href="{{ url('panduan') }}">Panduan</a></li>
                <li><a href="{{ url('tentang') }}">Tentang</a></li>
                @auth
                <li><a href="{{ route('history') }}">Histori</a></li>
            @endauth
            </ul>
        </nav>

        <!-- Login Button or User Dropdown (Aligned Right) -->
        <div class="header-login login-section">
            @guest
                <a style="text-decoration:none"  href="{{ route('login-usr') }}" style="color: white">
                    <i class="bi bi-door-open-fill"></i> Login
                </a>
            @else
            <i class="bi bi-person-fill" style="color: white"></i>&nbsp;
                <div class="nav-item dropdown">
                    <a style="text-decoration:none"  id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white">
                        {{ Auth::user()->usr_nama }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>
