@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Register -
@endsection

@section('content')
    <div id="app">
        <auth-register-box></auth-register-box>
    </div>
@endsection
