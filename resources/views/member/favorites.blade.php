@extends('layouts.base')

@section('title')
    Favorites -
@endsection

@section('content')
    <h3 class="text-center">Hi {{ auth()->user()['name'] }}!</h3>
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include("member._nav")
        </div>
        <div class="col-lg-9 col-md-8">
            ...
        </div>
    </div>
@endsection
