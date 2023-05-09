@extends('_layouts.base')

@section('title')
    Favorites -
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include("profile._nav")
        </div>
        <div class="col-lg-9">
            ...
        </div>
    </div>
@endsection

@section('inline_scripts')
    @vite('resources/js/profile/index.js')
@endsection

