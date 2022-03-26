@extends('layouts.base')

@section('title')
    My ADs -
@endsection

@section('content')
    <h3 class="text-center">Hi {{ auth()->user()['name'] }}!</h3>
    @include("member._nav")

@endsection
