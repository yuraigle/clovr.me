@extends('layouts.base')

@section('title')
    My ADs -
@endsection

@section('content')
    <h3 class="text-center">Hi {{ auth()->user()['name'] }}!</h3>
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include("member._nav")
        </div>
        <div class="col-lg-9 col-md-8">
            @foreach($rows as $row)
                <div class="pt-4 d-flex">
                    <img src="{{ "/images/" . substr($row->pic, 0, 4) . "/m_" . $row->pic . ".webp" }}"
                         width="200" height="150" alt="main_pic"/>
                    <div class="ms-3 me-auto">
                        <a href="#" class="h4 text-dark text-decoration-none">{{ $row->title }}</a><br/>
                        <strong class="text-info">
                            &euro;{{ number_format($row->price, 2) }}
                            @if($row->price_freq == 'per_month') per month
                            @elseif($row->price_freq == 'per_week') per week
                            @endif
                        </strong><br/>
                        <small class="text-muted">{{ $row->location }}</small>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-info btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">
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
                </div>
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
