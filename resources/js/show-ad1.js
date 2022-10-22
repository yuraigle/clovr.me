import "bootstrap/js/dist/modal.js";
import Lightbox from 'bs5-lightbox';

Lightbox.defaultSelector = '[data-toggle="lightbox"]';

const elMapModal = document.getElementById("map_modal");
const elMapCont = document.getElementById("map_cont");
const lng = elMapCont.getAttribute("data-lng");
const lat = elMapCont.getAttribute("data-lat");
let map1 = null;
let marker1 = null;

window.addEventListener("resize", function () {
    if (map1 && elMapModal && !elMapModal.classList.contains("show")) {
        map1.remove();
        map1 = null;
    }
});

const elMapPh = document.getElementById("map_placeholder");
if (elMapPh) {
    const lng = elMapPh.getAttribute('data-lng');
    const lat = elMapPh.getAttribute('data-lat');
    const url = `https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/${lng},${lat},13,0/550x250` +
        `?logo=false&access_token=${window.mapboxToken}`;
    elMapPh.setAttribute("src", url);
}

elMapModal.addEventListener("shown.bs.modal", function () {
    if (map1 == null) {
        marker1 = new window.mapbox.Marker();
        map1 = new window.mapbox.Map({
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
