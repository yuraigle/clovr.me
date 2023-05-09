@extends('_layouts.base')

@section('title')
    Register -
@endsection

@section('content')
    <div id="app">
        <auth-register-box></auth-register-box>
    </div>
@endsection

@section('inline_scripts')
    @vite('resources/js/auth/register.js')
@endsection
