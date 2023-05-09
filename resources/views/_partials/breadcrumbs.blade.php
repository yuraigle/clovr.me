<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        @foreach(App\Helpers\Breadcrumbs::for($town, $cat, $ad) as $b)
            <li class="breadcrumb-item {{ $b['active'] ? 'active' : '' }}">
                @if($b['active'])
                    {{ $b['name'] }}
                @else
                    <a href="{{ $b['path'] }}">{{ $b['name'] }}</a>
                @endif
            </li>
        @endforeach

    </ol>
</nav>
