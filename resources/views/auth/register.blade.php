@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Register -
@endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/vendors-vue.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/dist/register1.js') }}"></script>
@endsection
