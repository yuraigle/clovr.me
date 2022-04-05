@extends('layouts.base')

@section('content')

    <div class="row">
        <div class="col-lg-6 col-xl-5">
            <div class="card shadow-sm mb-4">
                <div class="d-flex">
                    <img src="/x_rent.webp" alt="Flats for Rent" style="width: 50%"/>
                    <div class="mx-4 my-2" style="width: 50%">
                        <h3 class="h6">Rent a Flat</h3>
                        <ul class="list-unstyled small">
                            <li><a href="#">Studios</a></li>
                            <li><a href="#">1 bedroom</a></li>
                            <li><a href="#">2 bedroom</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="d-flex">
                    <div class="mx-4 my-2" style="width: 50%">
                        <h3 class="h6">Flat & House Share</h3>
                        <ul class="list-unstyled small">
                            <li><a href="#">Shared Houses</a></li>
                            <li><a href="#">Shared Flats</a></li>
                            <li><a href="#">Couch Surf</a></li>
                        </ul>
                    </div>
                    <img src="/x_share.webp" alt="Flat & House Share" style="width: 50%"/>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-xl-5">
            <div class="card shadow-sm mb-4">
                <div class="d-flex">
                    <img src="/x_buy.webp" alt="Houses for Sale" style="width: 50%"/>
                    <div class="mx-4 my-2" style="width: 50%">
                        <h3 class="h6">Property for Sale</h3>
                        <ul class="list-unstyled small">
                            <li><a href="#">Houses</a></li>
                            <li><a href="#">Studios</a></li>
                            <li><a href="#">1 bedroom</a></li>
                            <li><a href="#">2 bedroom</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="d-flex">
                    <div class="mx-4 my-2" style="width: 50%">
                        <h3 class="h6">Garages & Parking</h3>
                        <ul class="list-unstyled small">
                            <li><a href="#">Garages for sale</a></li>
                            <li><a href="#">Parking places to rent</a></li>
                        </ul>
                    </div>
                    <img src="/x_garage.webp" alt="Garages & Parking" style="width: 50%"/>
                </div>
            </div>
        </div>

        <div class="col-xl-2">
            XL2
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
