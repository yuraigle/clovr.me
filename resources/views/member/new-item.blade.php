@extends('layouts.base')

@section('meta')
    <meta name="town" content="{{ $town }}">
@endsection

@section('title')
    Post an Ad -
@endsection

@section('content')
    <h3 class="text-center">Post an Ad</h3>
    <div id="app">
        <new-item></new-item>
    </div>
@endsection

@section('inline_scripts')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet'/>
    <script async src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
    <script> window.mapboxToken = '{{ config('app.mapbox_token') }}'; </script>
    @vite('resources/js/member/member_index.js')
@endsection
