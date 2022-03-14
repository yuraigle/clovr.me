@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Upload Pictures -
@endsection

@section('content')
    <div class="width-850">
        <h1 class="text-center">Upload Pictures</h1>
    </div>
@endsection
