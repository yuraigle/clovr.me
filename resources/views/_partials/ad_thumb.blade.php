<div class="a_thumb d-inline-block me-2">
    <a href="{{ App\Helpers\AdUrl::canonical($ad) }}" title="{{ $ad->title }}">
        @include('_partials.ad_main_pic', ['ad' => $ad])
        <span class="a_thumb_price small text-white p-1">
            {!! App\Helpers\AdDetails::priceShort($ad) !!}
            {{ App\Helpers\AdDetails::freqShort($ad) }}
        </span>
        <span class="a_thumb_title small bg-dark text-white opacity-75">
            {{ Illuminate\Support\Str::of($ad->title)->limit(40) }}
        </span>
    </a>
</div>
