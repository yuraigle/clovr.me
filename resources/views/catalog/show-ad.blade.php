@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4 mb-2">
                <h1 class="h3 border-bottom mb-1 pb-2">{{ $ad->title }}</h1>
                <div class="aa_row d-flex mb-4">
                    <span class="me-auto text-muted">
                        @if($ad->town){{ $ad->town }}@endif
                        @if($ad->county && $ad->county !== $ad->town), {{ $ad->county }}@endif
                    </span>
                    <span class="aa_price">
                        &euro;{{ number_format($ad->price, 0) }}
                    </span>
                    <span class="ms-1 align-middle">
                        @if($ad->price_freq === 'per_week') per week
                        @elseif($ad->price_freq === 'per_month') per month
                        @endif
                    </span>
                </div>

                <div>
                    @if (false && $ad->pic)
                        <img src="{{ '/images/' . substr($ad->pic, 0, 4) . '/X_' . $ad->pic . '.webp' }}"
                             width="200" height="150" alt="pic"/>
                    @endif
                </div>

                <div class="row">
                    <div class="col-8 p-0">
                        <img
                            src="{{ '/images/' . substr($pics[0]->name, 0, 4) . '/x_' . $pics[0]->name . '.webp' }}"
                            alt="pic" width="100%" class="pe-1"/>
                    </div>
                    <div class="col-4 p-0" style="overflow: hidden">
                        <div>
                            <img
                                src="{{ '/images/' . substr($pics[1]->name, 0, 4) . '/x_' . $pics[1]->name . '.webp' }}"
                                alt="pic" width="100%" class="pb-1"/>
                        </div>
                        @php
                            $lng = floatval($ad->lng);
                            $lat = floatval($ad->lat);
                            $token = "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";
                            $mapUrl = "https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/$lng,$lat,11,0/600x400?logo=false&access_token=$token"
                        @endphp
                        <div class="map-static d-flex align-items-center justify-content-center"
                             style="background-image: url('{{ $mapUrl }}')">
                            <button class="btn btn-info btn-sm">
                                <i class="fa-solid fa-location-dot me-1"></i>
                                Show on map
                            </button>
                        </div>
                    </div>
                </div>

                <p class="text-center mt-2">{{ $ad->location }}</p>

                <div class="my-2">
                    @if($ad->postcode)<p class="mb-0">Postal Code: {{ $ad->postcode }}</p>@endif

                    @if($ad->property_type)
                        <p class="mb-0">Property Type: {{ ucfirst($ad->property_type) }}</p>
                    @endif

                    @if($ad->num_beds === 0)
                        <p class="mb-0">No. of Bedrooms: Studio</p>
                    @elseif($ad->num_beds)
                        <p class="mb-0">No. of Bedrooms: {{ $ad->num_beds }}</p>
                    @endif
                </div>

                <h5>Description</h5>
                <div class="text-muted">{!! nl2br($ad->description) !!}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 mb-2">
                <h5 class="h5">{{ $usr->name }}</h5>

                <a href="#" class="btn btn-warning">
                    <i class="fa-solid fa-message me-1"></i>
                    Message me
                </a>
            </div>

            <div class="d-flex py-2 my-4">
                <h5 class="me-auto">Share:</h5>
                <span>
                    <a href="#" style="color: #3b5998" title="Share on Facebook">
                        <i class="fa-2xl fa-brands fa-facebook-square"></i></a>
                    <a href="#" style="color: #00acee" title="Share on Twitter">
                        <i class="fa-2xl fa-brands fa-twitter-square"></i></a>
                    <a href="#" style="color: #656656" title="Share via Email">
                        <i class="fa-2xl fa-solid fa-square-envelope"></i></a>
                </span>
            </div>
        </div>
    </div>
@endsection

@section('inline_styles')
    <style>
        .aa_row {
            line-height: 26px
        }

        .aa_price {
            font-size: 26px;
            color: #1c628b;
        }

        .map-static {
            width: 100%;
            height: 50%;
            background-repeat: no-repeat;
            background-position: center center;
            border-bottom: 1px red;
        }
        .map-static:hover {
            opacity: 80%;
        }
    </style>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet'/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
    <script type="text/javascript">
        mapboxgl.accessToken =
            "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";
    </script>

    <script type="text/javascript" src="{{ mix('/dist/show-ad.js') }}"></script>
@endsection
