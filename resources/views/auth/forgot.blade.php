@extends('_layouts.base')

@section('title')
    Forgotten password -
@endsection

@section('content')
    <div id="app">
        <auth-forgot-box></auth-forgot-box>
    </div>
@endsection

@section('inline_scripts')
    @vite('resources/js/auth/forgot.js')
@endsection
