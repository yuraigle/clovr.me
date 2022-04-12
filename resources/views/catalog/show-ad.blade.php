@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex small mb-2">
                <span class="text-muted me-auto">
                    {{ \Carbon\Carbon::parse($ad->created_at)->diffForHumans() }}
                </span>
                <span class="text-primary">
                    <i class="fa-solid fa-eye me-1"></i>
                    0 views, 0 today
                </span>
            </div>
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
                        @if($ad->price_freq === 'per_week')
                            <span class="d-none d-md-inline-block">per week</span>
                            <span class="d-inline-block d-md-none">pw</span>
                        @elseif($ad->price_freq === 'per_month')
                            <span class="d-none d-md-inline-block">per month</span>
                            <span class="d-inline-block d-md-none">pm</span>
                        @endif
                    </span>
                </div>

                @php
                    $i = 0;
                    $w = 550;
                    $h = 250;
                    $lng = isset($ad) ? floatval($ad->lng) : 0;
                    $lat = isset($ad) ? floatval($ad->lat) : 0;
                    $token = "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";
                    $mapUrl = "https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/$lng,$lat,13,0/${w}x${h}" .
                        "?logo=false&access_token=$token";
                @endphp

                <div class="row">
                    <div class="col-sm-8 p-0">
                        <div class="ratio ratio-4x3 then-2x1">
                            @if(!empty($pics[0]))
                                <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                     data-src="{{ '/images/' . substr($pics[0]->name, 0, 4) . '/x_' . $pics[0]->name . '.webp' }}"
                                     data-toggle="lightbox"
                                     data-type="image"
                                     data-gallery="gallery1"
                                     data-title="{{ ++$i }} / {{ count($pics) }}"
                                     alt="Main picture"/>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="row m-0">
                            <div id="map1" class="col-6 col-sm-12 p-0" title="Show Map" data-bs-toggle="modal"
                                 data-bs-target="#map_modal">
                                <button class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span
                                        class="d-none d-sm-none d-md-inline-block d-lg-none d-xl-inline-block">Show map</span>
                                    <span
                                        class="d-inline-block d-sm-inline-block d-md-none d-lg-inline-block d-xl-none">Map</span>
                                </button>
                                <div class="ratio ratio-4x3 then-2x1">
                                    <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                         data-src="{{ $mapUrl }}" alt="map" style="object-fit: none"/>
                                </div>
                            </div>
                            <div style="position: relative" class="col-6 col-sm-12 p-0">
                                <div class="ratio ratio-4x3 then-2x1">
                                    @if(!empty($pics[1]))
                                        <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                             data-src="{{ '/images/' . substr($pics[1]->name, 0, 4) . '/x_' . $pics[1]->name . '.webp' }}"
                                             data-toggle="lightbox"
                                             data-type="image"
                                             data-gallery="gallery1"
                                             data-title="{{ ++$i }} / {{ count($pics) }}"
                                             alt="More pictures"/>
                                    @endif
                                </div>
                                @if(count($pics) > 2)
                                    <div class="badge bg-dark" style="position: absolute; bottom: 5px; right: 5px">
                                        +{{ count($pics) - 2 }}
                                        <i class="fa-solid fa-images"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @foreach(array_slice($pics, 2) as $pic)
                    <div class="d-none"
                         data-src="{{ '/images/' . substr($pic->name, 0, 4) . '/x_' . $pic->name . '.webp' }}"
                         data-toggle="lightbox"
                         data-type="image"
                         data-gallery="gallery1"
                         data-title="{{ ++$i }} / {{ count($pics) }}"
                    ></div>
                @endforeach

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
        <div class="col-lg-4">
            <div class="card p-4 d-flex mb-2">
                <div class="mb-2">
                    <img src="/m_noavatar.webp" alt="" width="64" height="64" class="float-end ms-4"/>

                    <h5 class="h5">{{ $usr->name }}</h5>

                    @if($usr->phone)
                        <div>
                            <i class="fa-solid fa-phone me-1"></i>
                            Call me: {{ $usr->phone }}
                        </div>
                    @endif
                </div>

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

    <div class="modal fade" id="map_modal" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="map_cont" style="height: 500px" data-lng="{{ $lng }}" data-lat="{{ $lat }}"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inline_styles')
    <link rel="canonical" href="{!! AdUrl::canonical($ad) !!}"/>
    <style>
        .aa_row {
            line-height: 26px
        }

        .aa_price {
            font-size: 26px;
            color: #1c628b;
        }

        #map1 {
            position: relative
        }

        #map1 button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
        }

        div.ratio.ratio-4x3 > img {
            object-fit: cover;
            cursor: pointer;
        }

        div.ratio.ratio-4x3 > img:hover {
            opacity: 90%;
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
    <script type="text/javascript" src="{{ mix('/dist/show-0.js') }}"></script>
@endsection
