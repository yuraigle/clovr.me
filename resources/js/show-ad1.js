import "bootstrap/js/dist/modal.js";
import Lightbox from 'bs5-lightbox';
Lightbox.defaultSelector = '[data-toggle="lightbox"]';

const elMapModal = document.getElementById("map_modal");
const elMapCont = document.getElementById("map_cont");
const lng = elMapCont.getAttribute("data-lng");
const lat = elMapCont.getAttribute("data-lat");
let map1 = null;
let marker1 = null;

const imgMap = document.getElementById("map_placeholder");
if (imgMap) {
    const lng = imgMap.getAttribute('data-lng');
    const lat = imgMap.getAttribute('data-lat');
    const url = `https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/` +
        `${lng},${lat},13,0/550x250?logo=false&access_token=${window.mapboxToken}`;
    imgMap.setAttribute("src", url);
}

elMapModal.addEventListener("shown.bs.modal", function () {
    if (map1 == null) {
        marker1 = new mapboxgl.Marker();
        map1 = new mapboxgl.Map({
            accessToken: window.mapboxToken,
            container: elMapCont,
            style: "mapbox://styles/mapbox/streets-v11",
            center: [lng, lat],
            zoom: 16,
        });
    }

    marker1.setLngLat([lng, lat]).addTo(map1);
    map1.jumpTo([lng, lat]);
});

window.addEventListener("resize", function () {
    if (map1 && elMapModal && !elMapModal.classList.contains("show")) {
        map1.remove();
        map1 = null;
    }
});
