@extends('layouts.base')

@section('title')Post an Ad - @endsection

@section('content')
    <h1 class="text-center">Post an Ad</h1>

    <form action="{{ route('post-ad') }}" method="post" enctype="application/x-www-form-urlencoded">
        @csrf
        <div class="row">
            <div class="col-xs-12 mb-4">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option>Please select...</option>
                    <option value="1">Property For Sale</option>
                    <option value="2">Property To Rent</option>
                    <option value="3">Property To Share</option>
                    <option value="4">Parking & Garage For Sale</option>
                    <option value="5">Parking & Garage To Rent</option>
                </select>
            </div>

            <div class="col-xs-12 mb-4">
                <label for="title" class="form-label">Ad Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>

            <div class="col-sm-6 mb-2">
                <label for="price" class="form-label">Price:</label>
                <input type="text" class="form-control" id="price" name="price">
            </div>

            <div class="col-sm-6 mb-2">
                <label for="property_type" class="form-label">Property Type:</label>
                <select class="form-control" id="property_type" name="property_type">
                    <option>Please select...</option>
                    <option value="flat">Flat</option>
                    <option value="house">House</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="col-sm-6 mb-4">
                <label for="num_beds" class="form-label">No. of Bedrooms:</label>
                <select class="form-control" id="num_beds" name="num_beds">
                    <option>Please select...</option>
                    <option value="0">Studio</option>
                    @for ($i = 1; $i <= 20; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <label for="description" class="form-label w-100">Description</label>
            <div class="col-lg-9 col-md-8">
                <textarea class="form-control" id="description" name="description" rows="6"></textarea>
            </div>
            <div class="col-lg-3 col-md-4 lh-sm">
                <small class="text-muted">
                    Enter as much information possible;
                    Ads with detailed and longer descriptions get more views and replies!
                </small>
            </div>

            <div class="row mt-4">
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Post My Ad
                    </button>
                </div>
                <div class="col-auto  lh-sm">
                    <small class="text-muted">
                        By selecting Post My Ad you agree you've read and accepted our
                        <a href="{{ route('terms') }}" target="_blank">Terms of Use</a>.
                    </small>
                </div>
            </div>
        </div>
    </form>
@endsection
