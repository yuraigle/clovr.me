@extends('layouts.base')

@section('title')
    Member area -
@endsection

@section('content')
    <h3 class="text-center">Hi {{ auth()->user()['name'] }}!</h3>

    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-folder-open me-1"></i>
                Manage my ADs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-envelope me-1"></i>
                Messages
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-star me-1"></i>
                Favorites
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="fa-solid fa-user-gear me-1"></i>
                My Details
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
                <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
                Logout
            </a>
        </li>
    </ul>
@endsection
