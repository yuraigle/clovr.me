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

    <h1 class="h4">{{ $cat->name }}</h1>

    <p>{{ number_format($paginator->total()) }} ads</p>

    @foreach ($paginator as $row)
        <div class="py-2 d-flex border-bottom a0">
            @if ($row->pic)
                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                     data-src="{{ '/images/' . substr($row->pic, 0, 4) . '/s_' . $row->pic . '.webp' }}"
                     width="120" height="90" alt="main_pic"/>
            @else
                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                     data-src="/s_noimg.webp" width="120" height="90" alt="main_pic"/>
            @endif
            <div class="ms-3 me-auto">
                <a href="{!! AdUrl::canonical($row) !!}"
                   class="h4 text-dark text-decoration-none">{{ $row->title }}</a><br/>
                <small class="text-muted">{{ $row->location }}</small>

                <strong class="text-info a0_pr">
                    &euro;{{ number_format($row->price, 0) }}
                    @if ($row->price_freq == 'per_month')
                        per month
                    @elseif($row->price_freq == 'per_week')
                        per week
                    @endif
                </strong>
                <span class="text-muted cr_at">
                    {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                </span>
            </div>
        </div>
    @endforeach

    <div class="my-4">
        {{ $paginator->render() }}
    </div>

@endsection

@section("inline_styles")
    <style>
        .a0 {
            position: relative;
        }

        .a0:hover {
            background-color: #f0f0f0;
        }

        .a0 .a0_pr {
            position: absolute;
            bottom: 5px;
            left: 136px;
        }

        .a0 .cr_at {
            position: absolute;
            bottom: 5px;
            right: 0;
        }
    </style>
@endsection
