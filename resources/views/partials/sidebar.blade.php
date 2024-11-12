<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ url('/dashboard') }}"><img src="{{ asset('assets/images/logo/logoNuansa1.png') }}" alt="Logo"
                            srcset="" style="width: 200px;height: 50px;object-fit: cover;margin-top: 20px;"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                @foreach (session('menus')->where('menu_parent', 0) as $item)
                    <li class="sidebar-item {{ $item->menu_url ? '' : 'has-sub' }}">
                        <a href="{{ Route::has($item->menu_url) ? route($item->menu_url) : 'javascript:;' }}"
                            class='sidebar-link'>
                            <i class="{{ $item->menu_icon }}"></i>
                            <span>{{ $item->menu_nama }}</span>
                        </a>
                        @php
                            $submenu = session('menus')
                                ->where('menu_parent', '!=', 0)
                                ->where('menu_parent', $item->id_menu);
                        @endphp
                        @if ($submenu)
                            <ul class="submenu">
                                @foreach ($submenu as $submenuItem)
                                    <li class="submenu-item">
                                        <a href="{{ Route::has($submenuItem->menu_url) ? route($submenuItem->menu_url) : 'javascript:;' }}">{{ $submenuItem->menu_nama }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
