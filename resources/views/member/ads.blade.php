@extends('layouts.base')

@section('title')
    My ADs -
@endsection

@section('content')
    <h3 class="text-center">Hi {{ auth()->user()['name'] }}!</h3>
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include('member._nav')
        </div>
        <div class="col-lg-9 col-md-8">
            @foreach ($rows as $row)
                <article class="p-2 d-flex border-bottom">
                    <img src="{{ AdPic::placeholder() }}" data-src="{{ AdPic::main($row, 'm') }}"
                        width="200" height="150" alt="main_pic"/>

                    <div class="a1 ms-3 me-auto">
                        <a href="{{ AdUrl::canonical($row) }}"
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
        .dropdown-toggle::after {
            content: none !important;
            border: none !important;
        }

    </style>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="{{ mix('/dist/member-0.js') }}"></script>
@endsection
