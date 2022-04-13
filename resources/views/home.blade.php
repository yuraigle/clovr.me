@extends('layouts.base')

@section('cover1')
    <section class="cover1" style="background-image: url('/cover_house.webp')">
        <form class="container" method="get" action="{{ route('search') }}">
            <button class="btn btn-sm btn-dark opacity-75 location_btn" type="button" data-bs-toggle="modal"
                    data-bs-target="#locationModal">
                <i class="fa fa-location-arrow me-1"></i>
                {{ $town }}
            </button>

            <div class="d-flex opacity-75 mb-1">
                <button class="btn btn-dark py-1 me-2 cat1" type="button" data-cat1="sale">Sale</button>
                <button class="btn btn-light py-1 me-2 cat1" type="button" data-cat1="rent">Rent</button>
                <button class="btn btn-light py-1 cat1" type="button" data-cat1="share">Share</button>
            </div>

            <div class="input-group shadow-sm mb-2">
                <button class="btn btn-light dropdown-toggle py-2 px-3" type="button" data-bs-toggle="dropdown">
                    <span class="sp_prop1" id="prop1_house">
                        <i class="fa-solid fa-house-chimney fa-fw me-1"></i> House
                    </span>
                    <span class="sp_prop1 d-none" id="prop1_flat">
                        <i class="fa-solid fa-city fa-fw me-1"></i> Apartment
                    </span>
                    <span class="sp_prop1 d-none" id="prop1_garage">
                        <i class="fa-solid fa-warehouse fa-fw me-1"></i> Garage
                    </span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="btn btn-link dropdown-item prop1" type="button" data-prop1="house">
                            <i class="fa-solid fa-house-chimney fa-fw me-1"></i> House
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-link dropdown-item prop1" type="button" data-prop1="flat">
                            <i class="fa-solid fa-city fa-fw me-1"></i> Apartment
                        </button>
                    </li>
                    <li id="garage2">
                        <button class="btn btn-link dropdown-item prop1" type="button" data-prop1="garage">
                            <i class="fa-solid fa-warehouse fa-fw me-1"></i> Garage
                        </button>
                    </li>
                </ul>
                <input type="search" class="form-control py-2 px-3" id="q" name="q"
                       placeholder="Address, location, keyword...">
            </div>

            <div class="text-end">
                <button class="btn btn-light me-1">
                    <i class="fa fa-fw fa-location me-1"></i> Show on the map
                </button>
                <button class="btn btn-info">
                    Search <i class="fa fa-fw fa-arrow-right ms-1"></i>
                </button>
            </div>

            <input type="hidden" id="prop1" name="prop" value="house">
            <input type="hidden" id="cat1" name="cat" value="sale">
        </form>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-3">
                <table>
                    <tr>
                        <td style="background-image: url('/x_rent.webp')"></td>
                        <td class="px-4 py-2">
                            <h3 class="h6">Rent a Flat</h3>
                            <ul class="list-unstyled small">
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-rent']) }}">Studios</a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-rent']) }}">1 bedroom</a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-rent']) }}">2 bedroom</a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card shadow-sm mb-3">
                <table>
                    <tr>
                        <td class="px-4 py-2">
                            <h3 class="h6">Flat & House Share</h3>
                            <ul class="list-unstyled small">
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-share']) }}">Shared Houses</a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-share']) }}">Shared Flats</a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-share']) }}">Couch Surf</a>
                                </li>
                            </ul>
                        </td>
                        <td style="background-image: url('/x_share.webp')"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm mb-3">
                <table>
                    <tr>
                        <td style="background-image: url('/x_buy.webp')"></td>
                        <td class="px-4 py-2">
                            <h3 class="h6">Property for Sale</h3>
                            <ul class="list-unstyled small">
                                <li><a href="{{ route('show-cat', ['cat' => 'property-for-sale']) }}">Houses</a></li>
                                <li><a href="{{ route('show-cat', ['cat' => 'property-for-sale']) }}">Studios</a></li>
                                <li><a href="{{ route('show-cat', ['cat' => 'property-for-sale']) }}">1 bedroom</a></li>
                                <li><a href="{{ route('show-cat', ['cat' => 'property-for-sale']) }}">2 bedroom</a></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card shadow-sm mb-3">
                <table>
                    <tr>
                        <td class="px-4 py-2">
                            <h3 class="h6">Garages & Parking</h3>
                            <ul class="list-unstyled small">
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'garage-parking-for-sale']) }}">
                                        Garages for sale</a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'garage-parking-to-rent']) }}">
                                        Parking places to rent</a>
                                </li>
                            </ul>
                        </td>
                        <td style="background-image: url('/x_garage.webp')"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 px-4 py-2">
        <h3 class="h6">Featured ADs</h3>
        <p>{{ $town }}</p>
    </div>

    <h3 class="mt-4">Latest1 ADs</h3>
    @foreach ($rows as $row)
        <div class="pt-4 d-flex">
            @if ($row->pic)
                <img src="{{ '/images/' . substr($row->pic, 0, 4) . '/s_' . $row->pic . '.webp' }}" width="120"
                     height="90" alt="main_pic"/>
            @else
                <img src="/s_noimg.webp" width="120" height="90" alt="main_pic"/>
            @endif
            <div class="ms-3 me-auto">
                <a href="{!! AdUrl::canonical($row) !!}" class="h4 text-dark text-decoration-none">{{ $row->title }}</a><br/>
                <strong class="text-info">
                    &euro;{{ number_format($row->price, 0) }}
                    @if ($row->price_freq == 'per_month')
                        per month
                    @elseif($row->price_freq == 'per_week')
                        per week
                    @endif
                </strong><br/>
                <small class="text-muted">{{ $row->location }}</small>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="locationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row lh-lg text-center pb-2">
                        @foreach($towns as $t)
                            <div class="col-4">
                                <a class="btn btn-link {{ $town == $t ? 'disabled text-black fw-bold' : '' }}"
                                   href="?loc={{ $t }}">{{ $t }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/home-0.js') }}"></script>
@endsection
