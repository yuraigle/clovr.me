@extends('layouts.base')

@section('title')Post an Ad - @endsection

@section('content')
    <h1 class="text-center">Post an Ad</h1>

    <form action="{{ route('post-ad') }}" method="post" enctype="application/x-www-form-urlencoded">
        @csrf
        <div id="app"></div>
    </form>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="/dist/post_ad.bundle.js"></script>
@endsection
