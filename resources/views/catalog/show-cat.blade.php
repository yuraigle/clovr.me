@extends('_layouts.base')

@section('content')

    @include('_partials.breadcrumbs', ['town' => $town, 'cat' => $cat, 'propType' => $propType, 'ad' => null])

    <h1 class="h3">{{ $cat->name }}</h1>

    <p>{{ number_format($paginator->total()) }} ads</p>

    <div class="row">
        <div class="col-lg-3">
            <div class="sticky-lg-top pt-4">
                <h4>Filters</h4>
            </div>
        </div>
        <div class="col-lg-9 p-0">
            <div class="bg-white shadow-sm">
                @foreach ($paginator as $ad)
                    @include("_partials.ad_line", ["ad" => $ad])
                @endforeach
            </div>
            <div class="my-4">
                {{ $paginator->render() }}
            </div>
        </div>
    </div>
@endsection

@section('inline_scripts')
    @vite('resources/js/common.js')
@endsection
