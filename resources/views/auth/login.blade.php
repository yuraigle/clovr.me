@extends('layouts.base')

@section('title')Login - @endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/auth-login-box.js') }}"></script>
@endsection
