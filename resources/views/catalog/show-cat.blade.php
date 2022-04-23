@extends('layouts.base')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Property in {{ $town }}</a>
            </li>
            <li class="breadcrumb-item active">
                For Sale
            </li>
        </ol>
    </nav>

    <h1 class="h3">{{ $cat->name }}</h1>

    <p>{{ number_format($paginator->total()) }} ads</p>

    <div class="row">
        <div class="col-lg-3">
            <div class="sticky-lg-top pt-4">
                <h4>Filters</h4>
                AZAZA
            </div>
        </div>
        <div class="col-xxl-7 col-xl-8 col-lg-9 p-0">
            <div class="bg-white shadow-sm">
                @foreach ($paginator as $row)
                    <article class="a0 border-bottom hover-milk position-relative p-2">
                        <a href="{{ AdUrl::canonical($row) }}" class="d-flex text-dark text-decoration-none py-2">

                            <img src="{{ AdPic::placeholder() }}" data-src="{{ AdPic::main($row, "m") }}"
                                 width="200" height="150" alt="main_pic"/>

                            <div class="flex-grow-1 ms-3">
                                <h5 class="text-primary" style="margin-right: 40px">{{ Str::of($row->title)->limit(100) }}</h5>

                                @if ($row->location)
                                    <strong>{{ $row->location }}</strong>
                                @endif

                                <div class="small lh-sm text-muted my-2">
                                    {{ Str::of($row->description)->limit(150) }}
                                </div>

                                <div class="d-flex">
                                    <strong class="text-info me-auto">
                                        &euro;{{ number_format($row->price) }}
                                        {{ $row->price_freq ? preg_replace('|_|', ' ', $row->price_freq) : '' }}
                                    </strong>

                                    <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="fav pt-3 pe-3 pb-1 ps-1" title="Add to Favorites">
                            <i class="fa-lg fa-regular fa-heart"></i>
                        </a>
                    </article>
                @endforeach
            </div>
            <div class="my-4">
                {{ $paginator->render() }}
            </div>
        </div>

        <div class="d-lg-none d-xl-block col-xxl-2 col-xl-1">
            BANNER
        </div>
    </div>

@endsection
