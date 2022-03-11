@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">@endsection
@section('title')Post an Ad - @endsection

@section('content')
    <div class="width-850">
        <h1 class="text-center">Select a Location</h1>
        <div id="app"></div>
    </div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/new-ad-location.js') }}"></script>
@endsection
