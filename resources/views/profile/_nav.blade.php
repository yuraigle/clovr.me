@php
    $links = [
        'Profile' => ['profile', 'id'],
        'Security' => ['security', 'shield-lock'],
        'My ADs' => ['my-items', 'list-details'],
        'Messages' => ['messages', 'mail'],
        'Favorites' => ['favorites', 'star'],
    ];
@endphp

<div class="border-end">
    <div class="d-flex pb-2 mb-4">
        <img src="{{ App\Helpers\UserPic::main($user) }}" class="rounded d-block" width="64" alt="User Avatar">
        <div class="ms-2">
            <strong>{{ $user->name }}</strong><br/>
            <small class="text-muted">ID {{ $user->id }}</small>
        </div>
    </div>

    <ul class="nav flex-column mt-2 pt-2">
        @foreach($links as $k => $v)
            @if(request()->routeIs($v[0]))
                <li class="nav-item border-end border-primary border-2 bg-light">
                    <a class="nav-link disabled text-primary" href="{{ route($v[0]) }}">
                        @svg($v[1]) {{ $k }}
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link text-muted" href="{{ route($v[0]) }}">
                        @svg($v[1]) {{ $k }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>

    <ul class="nav flex-column border-top mt-2 pt-2">
        <li class="nav-item">
            <a class="nav-link text-muted" href="{{ route('logout') }}">
                @svg('logout') Logout
            </a>
        </li>
    </ul>
</div>
