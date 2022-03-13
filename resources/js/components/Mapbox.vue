<template>
  <div id="map" :class="{ 'd-none': !shown }"></div>
</template>

<script>
import { ref, watch, onMounted } from "vue";
import mapboxgl from "mapbox-gl";
import "mapbox-gl/dist/mapbox-gl.css";

export default {
  props: ["address", "center", "shown"],
  emits: ["marker-set"],

  setup(props, context) {
    const map = ref();
    const marker = ref();

    const geo_url = "https://api.mapbox.com/geocoding/v5/mapbox.places/";
    mapboxgl.accessToken =
      "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";

    let shownOnce = false;
    watch(
      () => props.shown,
      (v1) => {
        if (v1 && !shownOnce) {
          setTimeout(() => mountMap(), 100);
          shownOnce = true;
        }
      }
    );

    watch(props.address, (o) => {
      locate1(o);
    });

    let hasMarker = false;
    watch(props.center, (o) => {
      hasMarker = true;
      if (map.value) {
        marker.value.setLngLat(o).addTo(map.value);
      }
    });

    function mountMap() {
      map.value = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v11",
        center: [props.center.lng, props.center.lat],
        zoom: hasMarker ? 16 : 11,
      });

      marker.value = new mapboxgl.Marker({ draggable: true });

      if (hasMarker && props.center) {
        marker.value.setLngLat(props.center).addTo(map.value);
      }

      map.value.on("click", function (e) {
        marker.value.setLngLat(e.lngLat).addTo(map.value);
        const {lng, lat} = e.lngLat;
        context.emit("marker-set", null, lng, lat);
      });

      marker.value.on("dragend", function (e) {
        const {lng, lat} = e.target._lngLat;
        context.emit("marker-set", null, lng, lat);
      });
    }

    function locate1(o) {
      const str = [o.postcode, o.county, o.town, o.street].join(" ");
      const query = new URLSearchParams({
        access_token: mapboxgl.accessToken,
        types: "address",
        country: "ie",
        region: o.county,
        postcode: o.postcode,
        place: o.town,
        limit: 1,
      });

      fetch(geo_url + encodeURIComponent(str) + ".json?" + query.toString())
        .then((res) => res.json())
        .then((data) => {
          if (!data || !data.features || !data.features.length) return;

          const f = data.features[0];
          context.emit("marker-set", null, f.center[0], f.center[1]);
          if (map.value) {
            map.value.jumpTo({ center: f.center, zoom: 16 });
          }
        });
    }

    return {};
  },
};
</script>

<style>
#map {
  width: 100%;
  height: 400px;
  position: relative;
  overflow: hidden;
}

@media (min-width: 768px) {
  #map {
    height: 450px;
  }
}
</style>
