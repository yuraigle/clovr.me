<h4 class="border-bottom">Filters</h4>

<div class="row pt-2">
    <div class="col-12">
        <ul>
            <li><a href="#" class="text-decoration-none text-dark fw-bold">To Rent</a></li>
            <li><a href="#" class="text-decoration-none">For Sale</a></li>
            <li><a href="#" class="text-decoration-none">To Share</a></li>
        </ul>
    </div>
</div>

<div class="row pt-2">
    <label class="form-label">Property type</label>
    <div class="col-12">
        <ul>
{{--            <li><a href="#" class="text-decoration-none text-dark fw-bold">Any</a></li>--}}
            <li><a href="#" class="text-decoration-none">House</a></li>
            <li><a href="#" class="text-decoration-none">Apartment</a></li>
            <li><a href="#" class="text-decoration-none">Other</a></li>
        </ul>
    </div>
</div>

<div class="row pt-2">
    <label class="form-label" for="filter_price_to">Rent (per week)</label>
    <div class="col-6">
        <input class="form-control" name="filter[price_from]" id="filter_price_from" placeholder="From" />
    </div>
    <div class="col-6">
        <input class="form-control" name="filter[price_to]" id="filter_price_to" placeholder="To" />
    </div>
</div>

<div class="row pt-4">
    <div class="col-12">
        <button class="btn btn-success bg-gradient w-100">
            Apply
        </button>
    </div>
</div>
