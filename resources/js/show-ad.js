const el1 = document.getElementById("map");
const lng = el1.getAttribute("data-lng");
const lat = el1.getAttribute("data-lat");

const map1 = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
    center: [lng, lat],
    zoom: 16,
});

const marker1 = new mapboxgl.Marker();
marker1.setLngLat([lng, lat]).addTo(map1);
