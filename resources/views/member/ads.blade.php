@extends('layouts.base')

@section('title')
    My ADs -
@endsection

@section('content')
    <h3 class="text-center">Hi {{ auth()->user()['name'] }}!</h3>
    <div class="row">
        <div class="col-xxl-2 col-lg-3">
            @include('member._nav')
        </div>
        <div class="col-xxl-10 col-lg-9">
            @foreach ($rows as $row)
                <article class="a0 p-2 d-flex border-bottom">

                    <picture>
                        <source srcset="{{ App\Helpers\AdPic::main($row, 'm') }}" type="image/webp" media="(min-width: 769px)">
                        <source srcset="{{ App\Helpers\AdPic::main($row, 's') }}" type="image/webp" media="(max-width: 768px)">
                        <img src="{{ App\Helpers\AdPic::main($row, 'm', 'jpg') }}" alt="pic" loading="lazy">
                    </picture>

                    <div class="a1 ms-3 me-auto">
                        <a href="{{ App\Helpers\AdUrl::canonical($row) }}"
                           class="h5 text-decoration-none">
                           {{ Str::of($row->title)->limit(100) }}
                        </a>
                        <br/>

                        @if ($row->location)
                            <strong>{{ $row->location }}</strong>
                            <br/>
                        @endif

                        <div class="small lh-sm text-muted my-2">
                            {{ Str::of($row->description)->limit(150) }}
                        </div>

                        <div class="d-flex">
                            <strong class="a1pr text-info me-auto">
                                &euro;{{ number_format($row->price) }}
                                {{ $row->price_freq ? preg_replace('|_|', ' ', $row->price_freq) : '' }}
                            </strong>

                            <span class="a1dt text-muted">
                                {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('edit-ad', ['id' => $row->id]) }}" class="dropdown-item">
                                    <i class="fa-solid fa-pen me-1"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-trash-can me-1"></i>Archive
                                </a>
                            </li>
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endsection

@section('inline_styles')
    <style>
        .a0 picture, .a0 img {
            width: 200px;
            height: 150px;
            background-color: #eee;
        }

        @media (max-width: 768px) {
            .a0 picture, .a0 img {
                width: 120px;
                height: 90px;
            }
        }

        .dropdown-toggle::after {
            content: none !important;
            border: none !important;
        }

    </style>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/member-0.js') }}"></script>
@endsection
