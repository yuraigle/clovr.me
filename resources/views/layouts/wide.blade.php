<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <title>@yield('title')clovr.me</title>
    <link href="{{ mix('/dist/app-styles.css') }}" rel="stylesheet"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"/>
    <link rel="manifest" href="/site.webmanifest"/>

    @yield('inline_styles')
    <style>
        .a0 picture, .a0 img {
            width: 200px;
            height: 150px;
            background-color: #eee;
        }

        @media (max-width: 768px) {
            .a0 picture, .a0 img {
                width: 120px;
                height: 90px;
            }
        }
    </style>
</head>

<body class="d-flex flex-column">
<nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm ps-4 pe-4">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/logo.png" alt="Logo" width="32" height="32" class="d-inline-block align-text-top"/>
            <span class="brand ms-1">clovr</span>
        </a>
        <button class="navbar-toggler" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse py-2" id="navbar1">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a class="nav-link px-3 py-1 btn btn-sm btn-outline-warning {{ request()->routeIs('new-ad') ? 'active' : '' }}"
                       href="{{ route('new-ad') }}">
                        <i class="fa-solid fa-pen-to-square fa-fw me-1"></i>Post Ad
                    </a>
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link px-3 py-1 btn btn-sm {{ request()->routeIs('profile') ? 'active' : '' }}"
                           href="{{ route('profile') }}">
                            <i class="fa-solid fa-user fa-fw me-1"></i>{{ auth()->user()['name'] }}
                        </a>
                    @endauth
                    @guest
                        <a class="nav-link px-3 py-1 btn btn-sm {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">
                            <i class="fa-solid fa-user fa-fw me-1"></i>
                            <span class="d-inline-block d-sm-none">Login</span>
                        </a>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('cover1')

<main class="flex-grow-1">
    @yield('content')
</main>

<script type="text/javascript" src="{{ mix('/dist/app-scripts.js') }}"></script>
@yield('inline_scripts')
<link href="{{ mix('/dist/app-icons.css') }}" rel="stylesheet"/>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
</body>

</html>