<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<header>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('assets/images/logo/nuansa_fix.png')}}" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="{{url('')}}">Beranda</a></li>
                <div class="dropdown">
                    <li><a href="{{url('halaman-buku')}}">Buku</a></li>
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Dropdown
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                              <li><a class="dropdown-item" href="#">Action</a></li>
                              <li><a class="dropdown-item" href="#">Another action</a></li>
                              <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                          </li>
                        </ul>
                      </div>
                  </div>
                <li><a href="{{url('panduan')}}">Panduan</a></li>
                <li><a href="{{url('tentang')}}">Tentang</a></li>
                {{-- <li><a href="#"><img src="cart.png" alt="Cart"></a></li> --}}
            </ul>
        </nav>
        <div>
          <a class="dropdown-item" href="{{ route('login-usr') }}" style="color: white"><i class="bi bi-door-open-fill"></i> Login</a>
        </div>
    </div>
</header>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(event) {
            event.preventDefault();
            var menu = this.nextElementSibling;
            menu.classList.toggle('show');
        });
    });
});

</script>