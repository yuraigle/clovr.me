@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="town" content="{{ $town }}">
@endsection

@section('title')
    Post an Ad -
@endsection

@section('content')
    <h3 class="text-center">Post an Ad</h3>
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet'/>
    <script async src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
    <script> window.mapboxToken = '{{ config('app.mapbox_token') }}'; </script>
    <script type="text/javascript" src="{{ mix('/dist/new1.js') }}"></script>
@endsection
