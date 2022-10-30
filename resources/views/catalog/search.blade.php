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

@section('inline_styles')
    <link href="{{ mix('/dist/vendors-map-styles.css') }}" rel="stylesheet"/>
@endsection

@section('inline_scripts')
    <script> window.mapboxToken = '{{ config('app.mapbox_token') }}'; </script>
    <script type="text/javascript" src="{{ mix('/dist/vendors-vue.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/dist/vendors-map.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/dist/search1.js') }}"></script>
    <script async type="text/javascript" src="{{ mix('/dist/vendors-bs5.js') }}"></script>
@endsection
