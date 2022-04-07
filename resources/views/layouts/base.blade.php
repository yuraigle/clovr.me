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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    @yield('inline_styles')
</head>

<body class="d-flex flex-column">

<nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm ps-4 pe-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/logo-28x28.png" alt="Logo" width="28" height="28" class="d-inline-block align-text-top">
            clovr
        </a>
        <button class="navbar-toggler" type="button"><span class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-sm {{ request()->routeIs('search') ? 'active' : '' }}"
                       href="{{ route('search') }}">
                        <i class="fa-solid fa-magnifying-glass me-1"></i>Search
                    </a>
                </li>
                @guest
                    <li class="nav-item ms-1 me-1">
                        <a class="nav-link btn btn-sm btn-outline-warning {{ request()->routeIs('new-ad') ? 'active' : '' }}"
                           href="{{ route('login') }}?back=new-ad">
                            <i class="fa-solid fa-pen-to-square me-1"></i>Post Ad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">
                            <i class="fa-solid fa-user me-1"></i>Login
                        </a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item ms-1 me-1">
                        <a class="nav-link btn btn-sm btn-outline-warning {{ request()->routeIs('new-ad') ? 'active' : '' }}"
                           href="{{ route('new-ad') }}">
                            <i class="fa-solid fa-pen-to-square me-1"></i>Post Ad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm {{ request()->routeIs('profile') ? 'active' : '' }}"
                           href="{{ route('profile') }}">
                            <i class="fa-solid fa-user me-1"></i>
                            {{ auth()->user()['name'] }}
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@yield('cover1')

<main class="flex-grow-1 bg-light">
    <div class="container py-4">
        @yield('content')
    </div>
</main>

<footer class="mt-auto bg-dark py-4">
    <div class="container">
        <div class="col-sm-4">
            <a href="{{ route('about') }}" class="text-light">About Us</a><br/>
            <a href="{{ route('terms') }}" class="text-light">Terms of Use</a><br/>
        </div>
    </div>
    <div class="toast-container position-fixed p-3 bottom-0 end-0"></div>
</footer>

<script type="text/javascript" src="{{ mix('/dist/app-scripts.js') }}"></script>
@yield('inline_scripts')
<link href="{{ mix('/dist/app-icons.css') }}" rel="stylesheet"/>
</body>

</html>
