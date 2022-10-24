@extends('layouts.base')

@section('content')

    @include('partials.breadcrumbs', ['town' => $town, 'cat' => $cat, 'propType' => $propType, 'ad' => null])

    <h1 class="h3">{{ $cat->name }}</h1>

    <p>{{ number_format($paginator->total()) }} ads</p>

    <div class="row">
        <div class="col-lg-3">
            <div class="sticky-lg-top pt-4">
                <h4>Filters</h4>
            </div>
        </div>
        <div class="col-xxl-7 col-xl-8 col-lg-9 p-0">
            <div class="bg-white shadow-sm">
                @foreach ($paginator as $row)
                    <article class="a0 border-bottom hover-milk position-relative p-2">
                        <a href="{{ App\Helpers\AdUrl::canonical($row) }}"
                           class="d-flex text-dark text-decoration-none py-2">

                            @include('partials.ad_main_pic', ['row' => $row])

                            <div class="a1 flex-grow-1 ms-3">
                                <h5 class="text-primary me-5">
                                    {{ Illuminate\Support\Str::of($row->title)->limit(100) }}
                                </h5>

                                @if ($row->location)
                                    <strong>{{ $row->location }}</strong>
                                @endif

                                <div class="small lh-sm text-muted my-2">
                                    {{ Illuminate\Support\Str::of($row->description)->limit(150) }}
                                </div>

                                <strong class="a1pr text-info me-auto">
                                    {!! App\Helpers\AdPrice::full($row, 0) !!}
                                </strong>

                                <span class="a1dt text-muted">
                                    {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                </span>
                            </div>
                        </a>
                        <a href="#" class="fav pt-3 pe-3 pb-1 ps-1" title="Add to Favorites">
                            @svg('heart')
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
