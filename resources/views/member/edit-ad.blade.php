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
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet'/>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
    <script type="text/javascript" src="{{ mix('/dist/edit-0.js') }}"></script>
@endsection
