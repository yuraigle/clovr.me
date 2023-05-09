@extends('_layouts.wide')

@section('meta')
    <meta name="town" content="{{ $town }}">
@endsection

@section('title')
    Search -
@endsection

@section('content')
    <div id="app">
        <search-page></search-page>
    </div>
@endsection

@section('inline_scripts')
    <script> window.mapboxToken = '{{ config('app.mapbox_token') }}'; </script>
    @vite("resources/js/catalog/search.js")
@endsection
