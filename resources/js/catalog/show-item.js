import "@/js/common";
import "bootstrap/js/src/modal";
import "leaflet";

import Lightbox from "bs5-lightbox";

Lightbox.defaultSelector = '[data-toggle="lightbox"]';

const elMapModal = document.getElementById("map_modal");
const elMapCont = document.getElementById("map_cont");
const elMapImg = document.getElementById("map_placeholder");

if (elMapCont) {
    const x2 = L.Browser.retina ? '@2x' : '';
    const lng = elMapCont.getAttribute("data-lng");
    const lat = elMapCont.getAttribute("data-lat");
    const staticUrl = `https://api.mapbox.com/styles/v1/mapbox/streets-v11/static` +
        `/geojson(%7B%22type%22%3A%22Point%22%2C%22coordinates%22%3A%5B${lng}%2C${lat}%5D%7D)` +
        `/${lng},${lat},16,0/350x250${x2}?logo=false&attribution=false&access_token=${mapboxToken}`;
    const layerUrl = `https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}${x2}`
        + `?access_token=${mapboxToken}`;

    elMapImg.setAttribute("src", staticUrl);

    let map1 = null;
    elMapModal.addEventListener("shown.bs.modal", function () {
        if (map1 == null) {
            map1 = L.map('map_cont', {
                zoomAnimation: false,
                attributionControl: false,
            }).setView([lat, lng], 18);

            L.tileLayer(layerUrl, {
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                hq: L.Browser.retina,
                tileSize: 512,
                zoomOffset: -1
            }).addTo(map1);

            L.Icon.Default.imagePath = '/layout/';
            L.marker([lat, lng]).addTo(map1);
        }
    });

    window.addEventListener("resize", function () {
        if (map1 && !elMapModal.classList.contains("show")) {
            map1.remove();
            map1 = null;
        }
    });
}
