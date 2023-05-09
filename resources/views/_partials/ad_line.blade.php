<article class="a0 border-bottom hover-milk position-relative">
    <a href="{{ App\Helpers\AdUrl::canonical($ad) }}" class="d-flex text-dark text-decoration-none p-2">
        <div>
            <div class="position-relative">
                @include('_partials.ad_main_pic', ['ad' => $ad])
                @if($ad->npic > 1)
                    <span class="pics_counter" title="{{ $ad->npic }} photos">
                        @svg('mini-photo') {{ $ad->npic }}
                        <span class="visually-hidden">photos</span>
                    </span>
                @endif
            </div>
        </div>

        <div class="a1 flex-grow-1 ms-2">
            <h5 class="text-primary mb-1 me-5">
                {{ Illuminate\Support\Str::of($ad->title)->limit(100) }}
            </h5>

            @if ($ad->location)
                <span class="small">{{ App\Helpers\AdDetails::locationFull($ad) }}</span>
            @endif

            <div class="a1__details">
                @if($s = App\Helpers\AdDetails::propType($ad))
                    <span>{{ $s }}</span>
                @endif
                @if($s = App\Helpers\AdDetails::numBeds($ad))
                    <span>{{ $s }}</span>
                @endif
                @if($s = App\Helpers\AdDetails::roomType($ad))
                    <span>{{ $s }}</span>
                @endif
            </div>

            <div class="small lh-sm text-muted my-2">
                {{ Illuminate\Support\Str::of($ad->description)->limit(150) }}
            </div>

            <strong class="a1pr text-info me-auto">
                {!! App\Helpers\AdDetails::priceFull($ad, 0) !!}
            </strong>

            <span class="a1dt text-muted small" title="{{ Carbon\Carbon::parse($ad->created_at)->format('d M H:i') }}">
                {{ Carbon\Carbon::parse($ad->created_at)->diffForHumans() }}
            </span>
        </div>
    </a>
    <a href="#" class="fav pt-3 pe-3 pb-1 ps-1" title="Add to Favorites">@svg('heart')</a>
</article>
