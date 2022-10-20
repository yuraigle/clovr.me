@extends('layouts.wide')

@section('title')
    Search -
@endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet'/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
    <script type="text/javascript">
        mapboxgl.accessToken =
            "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";
    </script>
    <script type="text/javascript" src="{{ mix('/dist/search.js') }}"></script>

    <style>
        #map, .mapboxgl-canvas-container.mapboxgl-interactive {
            cursor: default !important;
        }
    </style>
@endsection
