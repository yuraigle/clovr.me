<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('my-ads') ? 'active' : '' }}" href="{{ route('my-ads') }}">
            <i class="fa-solid fa-folder-open me-1"></i>
            Manage my ADs
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('messages') ? 'active' : '' }}" href="{{ route('messages') }}">
            <i class="fa-solid fa-envelope me-1"></i>
            Messages
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('favorites') ? 'active' : '' }}" href="{{ route('favorites') }}">
            <i class="fa-solid fa-star me-1"></i>
            Favorites
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
            <i class="fa-solid fa-user-gear me-1"></i>
            My Details
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
            Logout
        </a>
    </li>
</ul>
