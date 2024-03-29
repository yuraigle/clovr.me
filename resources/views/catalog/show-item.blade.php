@extends('_layouts.base')

@section('content')
    <div class="row">

        <div>
            @include('_partials.breadcrumbs', ['town' => $town, 'cat' => $cat, 'ad' => $ad])
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
                        {{ App\Helpers\AdDetails::locationFull($ad) }}
                    </span>
                    <span class="aa_price">{!! App\Helpers\AdDetails::priceShort($ad) !!}</span>
                    @if($ad->price_freq)
                        <span class="ms-1 align-middle">
                            <span class="d-none d-md-inline-block">{{ App\Helpers\AdDetails::freqFull($ad) }}</span>
                            <span class="d-inline-block d-md-none">{{ App\Helpers\AdDetails::freqShort($ad) }}</span>
                        </span>
                    @endif
                </div>

                @php $i = 0; @endphp

                <div class="row">
                    <div class="col-sm-8 p-0">
                        <div class="ratio ratio-4x3 then-2x1">
                            @if(!empty($pics[0]))
                                <img src="{{ App\Helpers\AdPic::placeholder() }}"
                                     data-src="{{ App\Helpers\AdPic::named($pics[0]->name, "1200") }}"
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
                                             data-src="{{ App\Helpers\AdPic::named($pics[1]->name, "1200") }}"
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
                         data-src="{{ App\Helpers\AdPic::named($pic->name, "1200") }}"
                         data-toggle="lightbox"
                         data-type="image"
                         data-gallery="gallery1"
                         data-title="{{ ++$i }} / {{ count($pics) }}"
                    ></div>
                @endforeach

                <div class="my-2">
                    @if($s = App\Helpers\AdDetails::propType($ad))
                        <p class="mb-0">Property Type: {{ $s }}</p>
                    @endif

                    @if($s = App\Helpers\AdDetails::numBeds($ad))
                        <p class="mb-0">No. of Bedrooms: {{ $s }}</p>
                    @endif

                    @if($s = App\Helpers\AdDetails::roomType($ad))
                        <p class="mb-0">Room Type: {{ $s }}</p>
                    @endif
                </div>

                <p class="h5">Description</p>
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
                                 data-src="{{ App\Helpers\UserPic::main($usr) }}"
                                 width="64" height="64" class="float-end ms-4"
                                 alt="Member Logo"
                            />
                        </a>

                        <h2 class="h5">
                            <a href="#" class="text-decoration-none text-primary">{{ $usr->name }}</a>
                        </h2>
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
                <h3 class="h5 me-auto">Share:</h3>
                <a href="#" class="color-fb px-1" title="Share on Facebook">@svg('brand-facebook')</a>
                <a href="#" class="color-tw px-1" title="Share on Twitter">@svg('brand-twitter')</a>
                <a href="#" class="color-gr px-1" title="Share via Email">@svg('mail')</a>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-8">
            <div class="d-flex mb-1">
                <div class="me-auto align-middle">
                    <h3 class="h5 m-0 pt-2">You may also like...</h3>
                </div>
                <button class="btn" aria-label="Previous">@svg('chevron-left')</button>
                <button class="btn" aria-label="Next">@svg('chevron-right')</button>
            </div>

            <div id="similar_items" style="height: 150px; overflow-y: hidden"></div>
        </div>
    </div>
@endsection

@section('inline_styles')

    <link rel="canonical" href="{{ App\Helpers\AdUrl::canonical($ad) }}"/>
    <script>window.adata = {id: {{$ad->id}}};</script>
@endsection

@section('inline_scripts')
    <script> window.mapboxToken = '{{ config('app.mapbox_token') }}'; </script>
    @vite("resources/js/catalog/show-item.js")
    <script type="text/javascript">
        fetch(`/similar?aid=${window.adata.id}`)
            .then((resp) => resp.text())
            .then((html) => {
                document.getElementById('similar_items').innerHTML += html;
            });
    </script>
@endsection
