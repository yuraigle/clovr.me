@extends('layouts.base')

@section('content')
    <h1 class="text-center h3">{{ $row->title }}</h1>

    <div class="row">
        <div class="col-sm-8">

            @if ($row->pic)
                <img src="{{ '/images/' . substr($row->pic, 0, 4) . '/m_' . $row->pic . '.webp' }}" width="200"
                     height="150" alt="pic"/>
            @endif

            <div id="map"></div>
            <p class="text-center">{{ $row->location }}</p>

            <div class="text-muted">
                {{ $row->description }}
            </div>
        </div>
        <div class="col-sm-4">
            Contact info
        </div>
    </div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet'/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
    <script type="text/javascript">
        mapboxgl.accessToken =
            "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";

        const map1 = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [{{ $row->lng }}, {{ $row->lat }}],
            zoom: 11
        });

        const marker1 = new mapboxgl.Marker();
        marker1.setLngLat([{{ $row->lng }}, {{ $row->lat }}]).addTo(map1)
    </script>
@endsection

@section('inline_styles')
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 16px;
        }
    </style>
@endsection
