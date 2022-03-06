<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <title>@yield('title')ADZ</title>

    <link rel="icon" href="/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .fa-solid {
            width: 16px;
            display: inline-block;
        }
    </style>
    @yield('inline_styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">ADZ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">About Us</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
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
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-light {{ request()->is('login') ? 'active' : '' }}"
                       href="{{ route('login') }}">
                        <i class="fa-solid fa-user me-1"></i>Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4 mb-4">@yield('content')</div>
{{--
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
--}}
<script type="text/javascript">
    const e1 = document.getElementsByClassName('navbar-toggler')[0];
    const e2 = document.getElementById('navbar1');
    e1.addEventListener('click', function () {
        e2.classList.toggle('show');
    })
</script>
<script src="https://kit.fontawesome.com/e0449c5598.js" crossorigin="anonymous"></script>
@yield('inline_scripts')
</body>
</html>
