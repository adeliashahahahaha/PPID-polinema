<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPID Polinema</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav x-data="{
        lastScroll: 0,
        visible: true,
        headerHeight: 0,
        isMenuOpen: false
    }"
    x-init="
        headerHeight = document.querySelector('header').offsetHeight;
        window.addEventListener('scroll', () => {
            let currentScroll = window.pageYOffset;
            if (!isMenuOpen) {
                visible = currentScroll < lastScroll || currentScroll <= 0;
            }
            lastScroll = currentScroll;
        });
        window.addEventListener('resize', () => {
            headerHeight = document.querySelector('header').offsetHeight;
        });
    "
    x-bind:style="'top: ' + headerHeight + 'px'"
    x-bind:class="{ 'hidden-nav': !visible && !isMenuOpen, 'visible-nav': visible || isMenuOpen }"
    class="navbar navbar-expand-lg bg-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @foreach ($navbar as $menu)
                        @if (empty($menu['children']))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ url($menu['wm_menu_url']) }}">
                                    {{ $menu['wm_menu_nama'] }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ $menu['wm_menu_nama'] }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($menu['children'] as $submenu)
                                        <li>
                                            <a class="dropdown-item" href="{{ url($submenu['wm_menu_url']) }}">
                                                {{ $submenu['wm_menu_nama'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
