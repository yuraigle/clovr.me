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

                @php
                    $lng = isset($ad) ? floatval($ad->lng) : 0;
                    $lat = isset($ad) ? floatval($ad->lat) : 0;
                    $token = "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";
                    $mapUrl = "https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/$lng,$lat,11,0/600x250?logo=false&access_token=$token";

                    $p1 = isset($pics[0]) ? $pics[0]->name : null;
                    $p2 = isset($pics[1]) ? $pics[1]->name : null;
                    $pic1 = $p1 ? '/images/' . substr($p1, 0, 4) . '/x_' . $p1 . '.webp' : "";
                    $pic2 = $p2 ? '/images/' . substr($p2, 0, 4) . '/x_' . $p2 . '.webp' :  "";
                @endphp

                <div class="row pics_row">
                    <div id="pic1" class="col-lg-8 pe-1 pic_wrap" style="height: 414px">
                        <div>
                            <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                 data-src="{{ $pic1 }}" alt="pic1"/>
                        </div>
                    </div>
                    <div class="col-lg-4 ps-0">
                        <div id="map1" class="pic_wrap" style="height: 205px" title="Show Map"
                             data-bs-toggle="modal" data-bs-target="#modal_map1">
                            <div>
                                <button class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Show map
                                </button>
                                <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                     data-src="{{ $mapUrl }}" alt="map"/>
                            </div>
                        </div>
                        <div id="pic2" class="mt-1 pic_wrap" style="height: 205px">
                            <div>
                                <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                     data-src="{{ $pic2 }}" alt="pic2"/>
                            </div>
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

    <div class="modal fade" id="modal_map1" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="map2" style="max-height: 600px" data-lng="{{ $lng }}" data-lat="{{ $lat }}"></div>
                </div>
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

        #map1:hover {
            opacity: 80%;
            cursor: pointer;
        }

        #map1 > div {
            position: relative
        }

        #map1 button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .pic_wrap > div {
            display: flex;
            width: 100%;
            height: 100%;
            overflow: hidden
        }

        .pic_wrap img {
            object-fit: cover;
            width: 100%;
        }

        @media (max-width: 992px) {
            .pics_row > div {
                padding: 0 !important;
            }

            #pic1 {
                margin-bottom: 4px;
            }
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
