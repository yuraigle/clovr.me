@extends('_layouts.base')

@section('title')
    Login -
@endsection

@section('content')
    <div id="app">
        <auth-login-box></auth-login-box>
    </div>
@endsection

@section('inline_scripts')
    @vite('resources/js/auth/login.js')
@endsection
