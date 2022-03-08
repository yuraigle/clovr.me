@extends('layouts.base')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">@endsection
@section('title')Post an Ad - @endsection

@section('content')
    <div class="width-850 mb-4">
        <h1 class="text-center">Select a Location</h1>

        <p class="text-center mt-4 mb-2">Enter location details:</p>
        <div id="app"></div>
    </div>

    <p class="text-center mt-2 mb-2">...or click on the map:</p>
    <div id="map"></div>

    <div class="width-850 mt-4">
        <form method="post" class="row">
            <div class="text-center" id="found_msg">
                <span id="found_res1" style="display: none">
                    Is this an accurate location of your home?<br/>
                    Drag the marker and point the exact location.
                </span>
                <span id="found_res0" style="display: none">
                    Nothing found. Try another search.<br/>
                </span>
            </div>

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
            margin: 0 auto;
        }

        #found_msg {
            height: 40px;
        }
    </style>
@endsection

@section('inline_scripts')
    <script type="text/javascript" src="/dist/new-ad-location.bundle.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
    <script type="text/javascript">
        const marker = new mapboxgl.Marker({draggable: true});
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
                types: 'address',
                country: 'ie',
                region: req.county,
                postcode: req.postcode,
                place: req.town,
                access_token: mapboxgl.accessToken,
                limit: 1,
            });
            const str = [req.postcode, req.county, req.town, req.address].join(' ');
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
                        document.getElementById('found_res1').style.display = 'block';
                        document.getElementById('found_res0').style.display = 'none';
                    } else {
                        marker.remove();
                        map.jumpTo({center: startPos, zoom: startZoom});
                        elBtn1.classList.add('disabled');
                        document.getElementById('found_res1').style.display = 'none';
                        document.getElementById('found_res0').style.display = 'block';
                    }
                });
        }

        map.on('click', function (e) {
            marker.setLngLat(e.lngLat).addTo(map);

            const query = new URLSearchParams({
                types: 'address',
                country: 'ie',
                access_token: mapboxgl.accessToken,
            });

            const {lng, lat} = e.lngLat;
            const url2 = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
                + lng + ',' + lat + '.json?' + query.toString();

            fetch(url2)
                .then((res) => res.json())
                .then((data) => fillInputs(data));
        })

        marker.on('dragend', function (e) {
            const query = new URLSearchParams({
                types: 'address',
                country: 'ie',
                access_token: mapboxgl.accessToken,
            });
            const {lng, lat} = e.target._lngLat;
            const url2 = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
                + lng + ',' + lat + '.json?' + query.toString();

            fetch(url2)
                .then((res) => res.json())
                .then((data) => fillInputs(data));
        })

        function fillInputs(data) {
            if (data && data.features && data.features.length > 0) {
                for (let c of data.features[0].context) {
                    if (c.id && c.id.startsWith('postcode.')) {
                        document.getElementById('_postcode').value = c.text;
                    }
                    if (c.id && c.id.startsWith('region.')) {
                        document.getElementById('_county').value = c.text;
                    }
                    if (c.id && c.id.startsWith('place.')) {
                        document.getElementById('_town').value = c.text;
                    }
                }
                document.getElementById('_address').value = data.features[0].text;
            }
            console.log(data);
        }
    </script>
@endsection
