@extends('layouts.base')

@section('title')Forgotten password - @endsection

@section('content')
    <div id="app"></div>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/vendors-vue.js') }}"></script>
    <script type="text/javascript" src="{{ mix('/dist/forgot1.js') }}"></script>
@endsection
