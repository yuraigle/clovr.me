@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="form-data" content="{{ $row_json }}">
@endsection

@section('title')
    Edit Ad -
@endsection

@section('content')
    <h3 class="text-center">Edit Ad</h3>
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
    <script type="text/javascript" src="{{ mix('/dist/edit-ad.js') }}"></script>
@endsection
