@extends('layouts.base')

@section('content')
    <div class="row">

        <div>
            @include('partials.breadcrumbs', ['town' => $town, 'cat' => $cat, 'ad' => $ad])
        </div>

        <div class="col-lg-8">
            <div class="d-flex small mb-2">
                <span class="text-muted me-auto">
                    {{ Carbon\Carbon::parse($ad->created_at)->diffForHumans() }}
                </span>
                <span class="text-primary">
                    @svg('mini-eye') 0 views, 0 today
                </span>
            </div>
            <div class="card p-4">
                <h1 class="h3 border-bottom mb-1 pb-2">{{ $ad->title }}</h1>
                <div class="aa_row d-flex mb-4">
                    <span class="me-auto text-muted">
                        {{ $ad->town }}
                        @if($ad->county && $ad->county !== $ad->town)
                            , {{ $ad->county }}
                        @endif
                        {{ $ad->postcode }}
                    </span>

                    <span class="aa_price">
                        &euro;{{ number_format($ad->price) }}
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

                @php $i = 0; @endphp

                <div class="row">
                    <div class="col-sm-8 p-0">
                        <div class="ratio ratio-4x3 then-2x1">
                            @if(!empty($pics[0]))
                                <img src="{{ App\Helpers\AdPic::placeholder() }}"
                                     data-src="{{ App\Helpers\AdPic::named($pics[0]->name, 'x') }}"
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
                            @if ($ad->lng && $ad->lat)
                                <div id="map1" class="col-6 col-sm-12 p-0" title="Show Map" data-bs-toggle="modal"
                                     data-bs-target="#map_modal">
                                    <button class="btn btn-sm btn-info opacity-75" type="button">
                                        @svg('mini-map-pin')
                                        <span
                                            class="d-none d-sm-none d-md-inline-block d-lg-none d-xl-inline-block">Show map</span>
                                        <span
                                            class="d-inline-block d-sm-inline-block d-md-none d-lg-inline-block d-xl-none">Map</span>
                                    </button>
                                    <div class="ratio ratio-4x3 then-2x1">
                                        <img src="{{ App\Helpers\AdPic::placeholder() }}"
                                             id="map_placeholder"
                                             class="fit-none"
                                             data-lng="{{ $ad->lng }}"
                                             data-lat="{{ $ad->lat }}"
                                             alt="map"
                                        />
                                    </div>
                                </div>

                                <div class="modal fade" id="map_modal" data-bs-keyboard="false" tabindex="-1">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div id="map_cont" data-lng="{{ $ad->lng }}"
                                                     data-lat="{{ $ad->lat }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-6 col-sm-12 p-0 position-relative">
                                <div class="ratio ratio-4x3 then-2x1">
                                    @if(!empty($pics[1]))
                                        <img src="{{ App\Helpers\AdPic::placeholder() }}"
                                             data-src="{{ App\Helpers\AdPic::named($pics[1]->name, 'x') }}"
                                             data-toggle="lightbox"
                                             data-type="image"
                                             data-gallery="gallery1"
                                             data-title="{{ ++$i }} / {{ count($pics) }}"
                                             alt="More pictures"/>
                                    @endif
                                </div>
                                @if(count($pics) > 2)
                                    <div class="badge bg-dark position-absolute" style="bottom: 5px; right: 5px">
                                        +{{ count($pics) - 2 }}
                                        @svg('mini-photo')
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @foreach(array_slice($pics, 2) as $pic)
                    <div class="d-none"
                         data-src="{{ App\Helpers\AdPic::named($pic->name, 'x') }}"
                         data-toggle="lightbox"
                         data-type="image"
                         data-gallery="gallery1"
                         data-title="{{ ++$i }} / {{ count($pics) }}"
                    ></div>
                @endforeach

                <p class="text-center mt-2">{{ $ad->location }}</p>

                <div class="my-2">
                    @if($ad->property_type)
                        <p class="mb-0">Property Type: {{ ucfirst($ad->property_type) }}</p>
                    @endif

                    @if($ad->num_beds === 0)
                        <p class="mb-0">No. of Bedrooms: Studio</p>
                    @elseif($ad->num_beds)
                        <p class="mb-0">No. of Bedrooms: {{ $ad->num_beds }}</p>
                    @endif

                    @if($ad->room_type == 'couch')
                        <p class="mb-0">Room Type: Couch Surf</p>
                    @elseif($ad->room_type)
                        <p class="mb-0">Room Type: {{ ucfirst($ad->room_type) }} room</p>
                    @endif
                </div>

                <h5>Description</h5>
                <div class="text-muted">{!! nl2br($ad->description) !!}</div>

                @if($ad->www)
                    <div class="text-center mt-2">
                        @svg('link')
                        <a href="{{ $ad->www }}" target="_blank">{{ $ad->www }}</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-4">
            <div class="small text-end text-muted">
                Member since {{ Carbon\Carbon::parse($usr->created_at)->format('F Y') }}
            </div>
            <div class="sticky-top pt-2">
                <div class="card p-4 d-flex mb-2">
                    <div class="mb-2">
                        <a href="#">
                            <img src="{{ App\Helpers\AdPic::placeholder() }}"
                                 data-src="/layout/m_noavatar.1666414708.webp"
                                 width="64" height="64" class="float-end ms-4"
                                 alt="Member Logo"
                            />
                        </a>

                        <h5 class="h5">
                            <a href="#" class="text-decoration-none text-primary">{{ $usr->name }}</a>
                        </h5>
                    </div>

                    <div class="d-flex">
                        @if($usr->phone)
                            <a href="tel:{{ $usr->phone }}" class="btn btn-warning flex-grow-1 w-50 me-2">
                                @svg('phone-call') Call me
                            </a>
                        @endif
                        <a href="#" class="btn btn-success flex-grow-1 w-50">
                            @svg('message') Message me
                        </a>
                    </div>
                </div>
            </div>

            <div class="d-flex py-2 my-4">
                <h5 class="me-auto">Share:</h5>
                <span>
                    <a href="#" class="color-fb" title="Share on Facebook">
                        @svg('brand-facebook')</a>
                    <a href="#" class="color-tw" title="Share on Twitter">
                        @svg('brand-twitter')</a>
                    <a href="#" class="color-gr" title="Share via Email">
                        @svg('mail')</a>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h3>You may also like...</h3>
        <div style="height: 200px">&nbsp;</div>
    </div>
@endsection

@section('inline_styles')
    <link rel="canonical" href="{{ App\Helpers\AdUrl::canonical($ad) }}"/>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet'/>
    <script async src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
    <script> window.mapboxToken = '{{ config('app.mapbox_token') }}'; </script>
    <script type="text/javascript" src="{{ mix('/dist/show1.js') }}"></script>
@endsection
