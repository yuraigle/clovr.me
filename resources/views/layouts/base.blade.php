<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <title>@yield('title')clovr.one</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="{{ mix('/dist/app-styles.css') }}" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <style>
        .fa-solid {
            width: 16px;
            display: inline-block;
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/logo-28x28.png" alt="Logo" width="28" height="28" class="d-inline-block align-text-top">
                clovr
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-light {{ request()->is('search') ? 'active' : '' }}"
                            href="{{ route('search') }}">
                            <i class="fa-solid fa-magnifying-glass me-1"></i>Search
                        </a>
                    </li>
                    <li class="nav-item ms-1 me-1">
                        <a class="nav-link btn btn-sm btn-outline-warning {{ request()->is('new-ad') ? 'active' : '' }}"
                            href="{{ route('new-ad') }}">
                            <i class="fa-solid fa-pen-to-square me-1"></i>Post Ad
                        </a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-light {{ request()->is('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">
                                <i class="fa-solid fa-user me-1"></i>Login
                            </a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-light {{ request()->is('member') ? 'active' : '' }}"
                                href="{{ route('member') }}">
                                <i class="fa-solid fa-user me-1"></i>
                                {{ auth()->user()['name'] }}
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

        </div>
    </nav>
    <div class="container mt-4 mb-4">@yield('content')</div>

    <div class="toast-container position-fixed p-3 bottom-0 end-0"></div>

    <script type="text/javascript" src="{{ mix('/dist/app-scripts.js') }}"></script>
    <script src="https://kit.fontawesome.com/e0449c5598.js" crossorigin="anonymous"></script>
    @yield('inline_scripts')
</body>

</html>
