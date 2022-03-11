@extends('layouts.base')

@section('title')Register - @endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/auth-register-box.js') }}"></script>
@endsection
