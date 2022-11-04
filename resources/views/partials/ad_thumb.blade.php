<div class="a_thumb d-inline-block me-2 mb-2">
    <a href="{{ App\Helpers\AdUrl::canonical($ad) }}" title="{{ $ad->title }}">
        @include('partials.ad_main_pic', ['row' => $ad])
        <span class="a_thumb_price small text-white p-1">
            &euro;{{ number_format($ad->price) }}
            {{ App\Helpers\AdPriceFreq::short($ad) }}
        </span>
        <span class="a_thumb_title small bg-dark text-white opacity-75">
            {{ Illuminate\Support\Str::of($ad->title)->limit(40) }}
        </span>
    </a>
</div>
