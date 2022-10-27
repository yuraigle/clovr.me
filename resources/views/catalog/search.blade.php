@extends('layouts.wide')

@section('meta')
    <meta name="town" content="{{ $town }}">
@endsection

@section('title')
    Search -
@endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet'/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
    <script> window.mapboxToken = '{{ config('app.mapbox_token') }}'; </script>
    <script type="text/javascript" src="{{ mix('/dist/search1.js') }}"></script>
@endsection
