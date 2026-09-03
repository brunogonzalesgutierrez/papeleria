<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid px-3 px-md-4">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="app-body d-flex">
            @auth
                @php
                    $navItemDashboard = ['route' => 'home', 'label' => 'Dashboard'];

                    $navItemsAdmin = [
                        ['route' => 'usuarios.index', 'label' => 'Usuarios', 'permiso' => 'usuarios.ver'],
                        ['route' => 'roles.index', 'label' => 'Roles y permisos', 'permiso' => 'roles.ver'],
                    ];

                    $navItems = [
                        ['route' => 'productos', 'label' => 'Productos'],
                        ['route' => 'categorias', 'label' => 'Categorías'],
                        ['route' => 'proveedores', 'label' => 'Proveedores'],
                        ['route' => 'clientes', 'label' => 'Clientes'],
                        ['route' => 'ventas', 'label' => 'Ventas'],
                        ['route' => 'pedidos', 'label' => 'Pedidos'],
                        ['route' => 'inventario', 'label' => 'Inventario'],
                        ['route' => 'reportes', 'label' => 'Reportes'],
                    ];
                @endphp
                <aside class="app-sidebar">
                    <nav class="nav flex-column">
                        <a href="{{ route($navItemDashboard['route']) }}"
                           class="sidebar-link {{ request()->routeIs($navItemDashboard['route']) ? 'active' : '' }}">
                            <span class="sidebar-dot"></span>
                            {{ $navItemDashboard['label'] }}
                        </a>

                        @if (auth()->user()->can('usuarios.ver') || auth()->user()->can('roles.ver'))
                            <div class="sidebar-section-label">Administración</div>
                            @foreach ($navItemsAdmin as $item)
                                @can($item['permiso'])
                                    <a href="{{ route($item['route']) }}"
                                       class="sidebar-link {{ request()->routeIs(explode('.', $item['route'])[0] . '.*') ? 'active' : '' }}">
                                        <span class="sidebar-dot"></span>
                                        {{ $item['label'] }}
                                    </a>
                                @endcan
                            @endforeach
                        @endif

                        @foreach ($navItems as $item)
                            <a href="{{ route($item['route']) }}"
                               class="sidebar-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                <span class="sidebar-dot"></span>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </aside>
            @endauth

            <main class="app-main flex-grow-1 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <style>
        .app-body {
            min-height: calc(100vh - 58px);
        }

        .app-sidebar {
            width: 230px;
            flex-shrink: 0;
            background: #fff;
            border-right: 1px solid rgba(0, 0, 0, 0.08);
            padding: 1.25rem 0.75rem;
        }

        .sidebar-section-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #94a3b8;
            padding: 0.9rem 0.75rem 0.35rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.55rem 0.75rem;
            border-radius: 0.5rem;
            color: #475569;
            text-decoration: none;
            font-size: 0.92rem;
            margin-bottom: 0.15rem;
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        .sidebar-link:hover {
            background-color: #eef2ff;
            color: #364fc7;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #4f7cff, #364fc7);
            color: #fff;
            font-weight: 600;
        }

        .sidebar-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.6;
            flex-shrink: 0;
        }

        .app-main {
            min-width: 0;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        @media (max-width: 767.98px) {
            .app-body {
                flex-direction: column;
            }

            .app-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            }

            .app-sidebar .nav {
                flex-direction: row !important;
                flex-wrap: wrap;
                gap: 0.25rem;
            }
        }
    </style>
</body>
</html>
