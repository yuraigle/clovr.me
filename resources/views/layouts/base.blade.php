<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <title>@yield('title')clovr.me</title>
    <link href="{{ mix('/dist/styles-bs5.css') }}" rel="stylesheet"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"/>
    <link rel="manifest" href="/site.webmanifest"/>

    @yield('inline_styles')
</head>

<body class="d-flex flex-column">
<nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm ps-4 pe-4">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/layout/logo.1666414703.png" alt="Logo" width="32" height="32" class="d-inline-block align-text-top"/>
            <span class="brand ms-1">clovr</span>
        </a>
        <button class="navbar-toggler" type="button" title="Toggle Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
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
                            <i class="fa-solid fa-user fa-fw"></i>
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

<script type="text/javascript" src="{{ mix('/dist/scripts-app.js') }}"></script>
@yield('inline_scripts')
<link href="{{ mix('/dist/styles-fa6.css') }}" rel="stylesheet"/>
</body>
</html>
