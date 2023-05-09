@extends('layouts.base')

@section('title')
    Profile -
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-4">
            @include("profile._nav", ["user" => $user])
        </div>
        <div class="col-lg-6 col-sm-8">
            <section class="card bg-white shadow mb-4">
                <div class="card-header">
                    Contact Details
                </div>
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                            <label for="name" class="form-label">Display name:</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                            <label for="email" class="form-label">Contact email:</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                            <label for="phone" class="form-label">Contact number:</label>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary bg-gradient" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </section>

            <section class="card bg-white shadow mb-5">
                <div class="card-header">
                    Profile Picture
                </div>
                <div class="card-body">
                    <form method="post" action="/member/avatar" id="form2" enctype="multipart/form-data">
                        @csrf
                        <label class="btn btn-primary bg-gradient">
                    <span>
                        @svg('camera') Upload Picture
                        <input
                            name="pic1"
                            type="file"
                            class="d-none"
                            accept="image/*"
                            onchange="document.getElementById('form2').submit()"
                        />
                    </span>
                        </label>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('inline_scripts')
    @vite('resources/js/profile/index.js')
@endsection
