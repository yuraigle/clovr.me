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
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include("member._nav")
        </div>
        <div class="col-lg-9 col-md-8">
            <div id="app"></div>
        </div>
    </div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet'/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script type="text/javascript" src="{{ mix('/dist/edit-ad.js') }}"></script>
@endsection
s
