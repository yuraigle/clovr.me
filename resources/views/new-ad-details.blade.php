@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Post an Ad -
@endsection

@section('content')
    <div class="width-850">
        <h1 class="text-center">Post an Ad</h1>
        <div id="app"></div>
    </div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
    <script type="text/javascript" src="{{ mix('/dist/new-ad-details.js') }}"></script>
@endsection
