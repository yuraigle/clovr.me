@extends('_layouts.base')

@section('cover1')
    <section class="cover1" style="background-image: url('/layout/cover_house.1666414708.webp')">
        <form class="container" method="get" action="{{ route('search') }}">
            <button class="btn btn-sm btn-dark opacity-75 location_btn" type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#locationModal">
                @svg('mini-location', '') {{ $town }}
            </button>

            <div class="d-flex opacity-75 mb-1">
                <button class="btn btn-dark py-1 me-2 cat1 bg-gradient" type="button"
                        data-search="cat-sale">Sale
                </button>
                <button class="btn btn-light py-1 me-2 cat1 bg-gradient" type="button"
                        data-search="cat-rent">Rent
                </button>
                <button class="btn btn-light py-1 cat1 bg-gradient" type="button"
                        data-search="cat-share">Share
                </button>
            </div>

            <div class="input-group mb-2">
                <button class="btn btn-light dropdown-toggle py-2 px-3 w-150px" type="button"
                        data-bs-toggle="dropdown">@svg('home-check') House
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="btn btn-link dropdown-item" type="button"
                                data-search="prop-house">
                            @svg('home-check') House
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-link dropdown-item" type="button"
                                data-search="prop-flat">
                            @svg('building-skyscraper') Apartment
                        </button>
                    </li>
                    <li id="garage2">
                        <button class="btn btn-link dropdown-item" type="button"
                                data-search="prop-garage">
                            @svg('building-warehouse') Garage
                        </button>
                    </li>
                </ul>
                <input type="search" class="form-control form-control-lg" id="q" name="q"
                       placeholder="Address, location, keyword...">
            </div>

            <div class="text-end">
                <button class="btn btn-light bg-gradient me-1" name="map" value="1" type="submit">
                    @svg('map-search') Show on the map
                </button>
                <button class="btn btn-success bg-gradient" type="submit">
                    Search @svg('arrow-right')
                </button>
            </div>

            <input type="hidden" name="prop" value="house">
            <input type="hidden" name="cat" value="sale">
        </form>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-3">
                <table>
                    <tr>
                        <td data-bg="/layout/x_rent.1666414709.webp"></td>
                        <td class="px-4 py-2">
                            <h3 class="h6">Rent a Flat</h3>
                            <ul class="list-unstyled small">
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-rent', 'propType' => 'flat']) }}">
                                        Studios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-rent', 'propType' => 'flat']) }}">
                                        1 bedroom
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-rent', 'propType' => 'flat']) }}">
                                        2 bedroom
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-rent', 'propType' => 'house']) }}">
                                        Houses
                                    </a>
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
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-share', 'propType' => 'house']) }}">
                                        Shared Houses
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-share', 'propType' => 'flat']) }}">
                                        Shared Flats
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-to-share']) }}">
                                        Couch Surf
                                    </a>
                                </li>
                            </ul>
                        </td>
                        <td data-bg="/layout/x_share.1666414709.webp"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm mb-3">
                <table>
                    <tr>
                        <td data-bg="/layout/x_buy.1666414709.webp"></td>
                        <td class="px-4 py-2">
                            <h3 class="h6">Property for Sale</h3>
                            <ul class="list-unstyled small">
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-for-sale', 'propType' => 'house']) }}">
                                        Houses
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-for-sale', 'propType' => 'flat']) }}">
                                        Studios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-for-sale', 'propType' => 'flat']) }}">
                                        1 bedroom
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'property-for-sale', 'propType' => 'flat']) }}">
                                        2 bedroom
                                    </a>
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
                            <h3 class="h6">Garages & Parking</h3>
                            <ul class="list-unstyled small">
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'garage-parking-for-sale', 'propType' => 'garage']) }}">
                                        Garages for sale
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('show-cat', ['cat' => 'garage-parking-to-rent', 'propType' => 'parking']) }}">
                                        Parking places to rent
                                    </a>
                                </li>
                            </ul>
                        </td>
                        <td data-bg="/layout/x_garage.1666414709.webp"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm px-4 pt-2 pb-3">
        <h3 class="h6">Featured ADs</h3>
        <div class="d-flex flex-nowrap overflow-hidden">
            @foreach($featured as $ad1)
                @include("_partials.ad_thumb", ["ad" => $ad1])
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="locationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" title="close"></button>
                </div>
                <div class="modal-body">
                    <div class="row lh-lg text-center pb-2">
                        @foreach($towns as $t)
                            <div class="col-4">
                                <a class="btn btn-link {{ $town == $t->getName() ? 'disabled text-black fw-bold' : '' }}"
                                   href="?loc={{ urlencode($t->getName()) }}">{{ $t->getName() }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inline_scripts')
    @vite('resources/js/catalog/home.js')
@endsection
