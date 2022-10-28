@extends('layouts.base')

@section('title')
    Security -
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-4">
            @include("member._nav")
        </div>
        <div class="col-lg-6 col-sm-8">
            <section class="card bg-white shadow mb-5">
                <div class="card-header">
                    Change Password
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="current_password" placeholder="*">
                            <label for="current_password" class="form-label">Current Password:</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="new_password" placeholder="*">
                            <label for="new_password" class="form-label">New Password:</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="repeat_password" placeholder="*">
                            <label for="repeat_password" class="form-label">Repeat Password:</label>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary bg-gradient" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection
