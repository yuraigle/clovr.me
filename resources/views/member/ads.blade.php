@extends('layouts.base')

@section('title')
    My ADs -
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include("member._nav")
        </div>
        <div class="col-lg-9">
            <section class="card bg-white shadow mb-5">
                @for($i = 0; $i < count($rows); $i++)
                    @php $row = $rows[$i] @endphp
                    <article class="a0 p-2 d-flex {{ $i == count($rows) - 1 ? '' : 'border-bottom' }}">
                        @include('partials.ad_main_pic', ['ad' => $row])

                        <div class="a1 ms-3 flex-grow-1">
                            <a href="{{ App\Helpers\AdUrl::canonical($row) }}"
                               class="h5 text-decoration-none">
                                {{ Illuminate\Support\Str::of($row->title)->limit(100) }}
                            </a>
                            <br/>

                            @if ($row->location)
                                <strong>{{ $row->location }}</strong>
                                <br/>
                            @endif

                            <div class="small lh-sm text-muted my-2">
                                {{ Illuminate\Support\Str::of($row->description)->limit(150) }}
                            </div>

                            <div class="d-flex">
                                <strong class="a1pr text-info me-auto">
                                    {!! App\Helpers\AdPrice::full($row, 0) !!}
                                </strong>

                                <span class="a1dt text-muted">
                                {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                            </span>
                            </div>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle" type="button"
                                    title="Options" data-bs-toggle="dropdown">
                                @svg('dots')
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('edit-ad', ['id' => $row->id]) }}" class="dropdown-item">
                                        @svg('mini-pencil') Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        @svg('mini-trash') Archive
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </article>
                @endfor
            </section>
        </div>
    </div>
@endsection

@section('inline_styles')
    <style>
        .dropdown-toggle::after {
            content: none !important;
            border: none !important;
        }

    </style>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/vendors-bs5.js') }}"></script>
@endsection
