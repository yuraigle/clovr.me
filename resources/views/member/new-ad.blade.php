@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Post an Ad -
@endsection

@section('content')
    <h3 class="text-center">Post an Ad</h3>
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet'/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
    <script type="text/javascript">
        mapboxgl.accessToken =
            "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";
    </script>

    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script type="text/javascript" src="{{ mix('/dist/new0.js') }}"></script>
@endsection
