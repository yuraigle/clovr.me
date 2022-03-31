@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4 mb-2">
                <h1 class="text-center h3 border-bottom mb-4 pb-2">{{ $row->title }}</h1>

                @if ($row->pic)
                    <img src="{{ '/images/' . substr($row->pic, 0, 4) . '/m_' . $row->pic . '.webp' }}" width="200"
                        height="150" alt="pic" />
                @endif

                <div id="map" class="mt-4" style="height: 400px" data-lng="{{ floatval($row->lng) }}"
                    data-lat="{{ floatval($row->lat) }}"></div>
                <p class="text-center border-bottom mb-4 pb-2">{{ $row->location }}</p>
                <div class="text-muted">{!! nl2br($row->description) !!}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 mb-2">
                <p class="h4">Contact info</p>
                AZAZA
            </div>
        </div>
    </div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
    <script type="text/javascript">
        mapboxgl.accessToken =
            "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";
    </script>

    <script type="text/javascript" src="{{ mix('/dist/show-ad.js') }}"></script>
@endsection
