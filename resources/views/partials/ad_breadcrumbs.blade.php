<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        <li class="breadcrumb-item">
            <a href="/">
                @if($ad && $ad->property_type === 'flat')
                    Flats in {{ $town }}
                @elseif($ad && $ad->property_type === 'house')
                    Houses in {{ $town }}
                @elseif($ad && in_array($ad->property_type, ['garage', 'parking']))
                    Garages & Parking in {{ $town }}
                @elseif($cat && preg_match('|Parking|', $cat->name))
                    Garages & Parking in {{ $town }}
                @else
                    Property in {{ $town }}
                @endif
            </a>
        </li>

        @if($cat && !$ad)
            <li class="breadcrumb-item active">
                @if($cat && preg_match('|To Rent|', $cat->name))
                    To Rent
                @elseif($cat && preg_match('|To Share|', $cat->name))
                    To Share
                @else
                    For Sale
                @endif
            </li>
        @elseif($ad)
            <li class="breadcrumb-item">
                <a href="/{{ $cat->slug }}">
                    @if($cat && preg_match('|To Rent|', $cat->name))
                        To Rent
                    @elseif($cat && preg_match('|To Share|', $cat->name))
                        To Share
                    @else
                        For Sale
                    @endif
                </a>
            </li>

            <li class="breadcrumb-item active">
                {{ Illuminate\Support\Str::of($ad->title)->limit(100) }}
            </li>
        @endif

    </ol>
</nav>
