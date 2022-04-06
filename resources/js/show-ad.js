import "bootstrap/js/dist/modal.js";
import "bootstrap/js/dist/carousel.js";
import Lightbox from "bs5-lightbox";

const elMapModal = document.getElementById("map_modal");
const elMapCont = document.getElementById("map_cont");
const lng = elMapCont.getAttribute("data-lng");
const lat = elMapCont.getAttribute("data-lat");
let map1 = null;
let marker1 = null;

const imgDefer = document.getElementsByTagName("img");
for (let i = 0; i < imgDefer.length; i++) {
    if (imgDefer[i].getAttribute("data-src")) {
        imgDefer[i].setAttribute("src", imgDefer[i].getAttribute("data-src"));
    }
}

window.addEventListener("resize", function () {
    if (map1 && elMapModal && !elMapModal.classList.contains("show")) {
        map1.remove();
        map1 = null;
    }
});

elMapModal.addEventListener("shown.bs.modal", function (e) {
    if (map1 == null) {
        marker1 = new mapboxgl.Marker();
        map1 = new mapboxgl.Map({
            container: elMapCont,
            style: "mapbox://styles/mapbox/streets-v11",
            center: [lng, lat],
            zoom: 16,
        });
    }

    marker1.setLngLat([lng, lat]).addTo(map1);
    map1.jumpTo([lng, lat]);
});
