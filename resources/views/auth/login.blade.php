@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Login -
@endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/vendors.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/dist/login1.js') }}"></script>
@endsection
