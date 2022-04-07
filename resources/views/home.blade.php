@extends('layouts.base')

@section('cover1')
    <section class="cover1" style="background-image: url('/cover.webp')">
        <form class="container">
            <div class="row">
                <div class="col-3 col-lg-2 mb-2">
                    <select class="form-select form-select-lg shadow-lg">
                        <option value="1">Sale</option>
                        <option value="2">Rent</option>
                    </select>
                </div>
                <div class="col-9 col-lg-10 mb-2">
                    <input type="search" class="form-control form-control-lg shadow-lg" id="q" name="q"
                           placeholder="Address, location, keyword...">
                </div>
            </div>

            <div class="text-end">
                <a class="btn btn-light" href="#">
                    <i class="fa fa-location me-1"></i>
                    Show on the map
                </a>
                <button class="btn btn-info">
                    Search
                    <i class="fa fa-arrow-right ms-1"></i>
                </button>
            </div>
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
                <a href="{!! AdUrl::canonical($row) !!}"
                   class="h4 text-dark text-decoration-none">{{ $row->title }}</a><br/>
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
@endsection

@section('inline_styles')
    <style>
        .card table {
            width: 100%;
            height: 150px;
        }

        .card table td {
            width: 50%;
            vertical-align: top;
        }

        .card table td {
            background-size: cover;
            background-position: center center;
        }
    </style>
@endsection
