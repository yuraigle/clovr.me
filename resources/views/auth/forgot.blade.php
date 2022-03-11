@extends('layouts.base')

@section('title')Forgotten password - @endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/auth-forgot-box.js') }}"></script>
@endsection
