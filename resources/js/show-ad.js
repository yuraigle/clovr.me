import "bootstrap/js/dist/modal.js";

const elPic1 = document.getElementById("pic1");
const elPic2 = document.getElementById("pic2");
const elMap1 = document.getElementById("map1");
const elMap2 = document.getElementById("map2");
const elMapModal = document.getElementById('modal_map1')

const el1 = document.getElementById("map2");
const lng = el1.getAttribute("data-lng");
const lat = el1.getAttribute("data-lat");
let map1 = null;
let marker1 = null;

function onResize() {
    const w1 = elPic1.offsetWidth;
    const h1 = Math.floor(w1 * 0.75) + 'px';
    const h2 = Math.floor(w1 * 0.75 / 2 - 2) + 'px';
    elPic1.style.height = h1;
    elPic2.style.height = h2;
    elMap1.style.height = h2;
    elMap2.style.height = Math.floor(window.innerHeight - 100) + 'px';

    if (map1 && elMapModal && !elMapModal.classList.contains("show")) {
        map1.remove();
        map1 = null;
    }
}

window.addEventListener("resize", onResize);

window.addEventListener("load", function () {
    onResize();

    const imgDefer = document.getElementsByTagName('img');
    for (let i = 0; i < imgDefer.length; i++) {
        if (imgDefer[i].getAttribute('data-src')) {
            imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-src'));
        }
    }
})

elMapModal.addEventListener('shown.bs.modal', function (e) {
    if (map1 == null) {
        marker1 = new mapboxgl.Marker();
        map1 = new mapboxgl.Map({
            container: "map2",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [lng, lat],
            zoom: 16,
        });
    }

    marker1.setLngLat([lng, lat]).addTo(map1);
    map1.jumpTo([lng, lat]);
})


