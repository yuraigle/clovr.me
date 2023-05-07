@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Login -
@endsection

@section('content')
    <div id="app">
        <auth-login-box></auth-login-box>
    </div>
@endsection
