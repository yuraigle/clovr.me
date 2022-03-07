@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">@endsection
@section('title')Post an Ad - @endsection

@section('content')
    <div class="width-850">
        <h1 class="text-center">Select a Location</h1>
        <div id="app"></div>

        <form method="post" class="row">
            <div class="w-100">
                <p class="mt-2 mb-2 text-center" id="msg1">&nbsp;</p>
            </div>

            <div id="map"></div>

            <div class="d-flex flex-row w-100 mt-2 mb-2">
                <a href="/new-ad" class="btn btn-secondary me-auto">
                    <i class="fa-solid fa-chevron-left"></i>
                    Back
                </a>
                <button type="button" class="btn btn-primary disabled" id="btn1">
                    Yes, it's the correct location
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('inline_styles')
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
    <style>
        .width-850 {
            max-width: 850px;
            margin: 0 auto;
        }

        #map {
            height: 500px;
            max-width: 850px;
            margin: 0 auto;
        }
    </style>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="/dist/new-ad-location.bundle.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
    <script type="text/javascript">
        const marker = new mapboxgl.Marker();
        const elMsg1 = document.getElementById('msg1');
        const elBtn1 = document.getElementById('btn1');
        const startPos = [-6.25, 53.35];
        const startZoom = 11;

        mapboxgl.accessToken = 'pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw';

        const map = new mapboxgl.Map({
            style: 'mapbox://styles/mapbox/streets-v11',
            container: 'map',
            center: startPos,
            zoom: startZoom,
        });

        window.showOnMap = function (req) {
            const query = new URLSearchParams({
                country: 'ie',
                types: 'address',
                postcode: req.postcode,
                place: req.town,
                access_token: mapboxgl.accessToken,
                limit: 1,
            });
            const str = req.unit + ' ' + req.street + ' ' + req.town;
            const url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
                + encodeURIComponent(str) + '.json?' + query.toString();

            fetch(url)
                .then((res) => res.json())
                .then((data) => {
                    if (data && data.features && data.features.length > 0) {
                        const coords = data.features[0].center;
                        marker.setLngLat(coords).addTo(map);
                        map.jumpTo({center: coords, zoom: 16});
                        elBtn1.classList.remove('disabled');
                        elMsg1.innerText = 'Is this an accurate location of your home?';
                    } else {
                        marker.remove();
                        map.jumpTo({center: startPos, zoom: startZoom});
                        elBtn1.classList.add('disabled');
                        elMsg1.innerText = 'Nothing found. Try another search.';
                    }
                });
        }

        map.on('click', function(e) {
            console.log(e.lngLat);
        })
    </script>
@endsection
