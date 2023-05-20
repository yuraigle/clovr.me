<nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand p-0" href="/">
            <img src="/layout/logo-default-1x.png"
                 srcset="/layout/logo-default-2x.png"
                 width="128" height="48"
                 class="d-inline-block"
                 alt="Site Logo"
            />
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item ms-2">
                    <a class="nav-link {{request()->segment(1) == 'property-for-sale' ? 'active' : '' }}"
                       href="{{ route('show-cat', ['cat' => 'property-for-sale']) }}">Buy</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link {{request()->segment(1) == 'property-to-rent' ? 'active' : '' }}"
                       href="{{ route('show-cat', ['cat' => 'property-to-rent']) }}">Rent</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link {{request()->segment(1) == 'property-to-share' ? 'active' : '' }}"
                       href="{{ route('show-cat', ['cat' => 'property-to-share']) }}">Share</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link" aria-current="page" href="#">Agents</a>
                </li>
            </ul>
        </div>

        <div class="navbar-expand">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link px-3 py-1 btn btn-sm btn-outline-warning {{ request()->routeIs('new-item') ? 'active' : '' }}"
                       href="{{ route('new-item') }}" title="Post Ad">
                        @svg('edit')
                        <span class="d-none d-md-inline-block text-dark">Post Ad</span>
                    </a>
                </li>
                <li class="nav-item ms-1">
                    @auth
                        <a class="nav-link px-3 py-1 btn btn-sm btn-outline-secondary {{ request()->routeIs('my-items') ? 'active' : '' }}"
                           href="{{ route('my-items') }}" title="User Details">
                            @svg('user')
                            <span class="d-none d-sm-inline-block text-dark">{{ auth()->user()['name'] }}</span>
                        </a>
                    @endauth
                    @guest
                        <a class="nav-link px-3 py-1 btn btn-sm btn-outline-secondary {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}" title="Login">
                            @svg('user')
                        </a>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>
