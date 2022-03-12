<template>
  <div id="map"></div>
</template>

<script>
import { onMounted, ref, watch } from "vue";
import mapboxgl from "mapbox-gl";
import "mapbox-gl/dist/mapbox-gl.css";

export default {
  props: ["address", "center"],
  emits: ["marker-set"],

  setup(props, context) {
    const map = ref();
    const marker = ref();

    const geo_url = "https://api.mapbox.com/geocoding/v5/mapbox.places/";
    mapboxgl.accessToken =
      "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";

    onMounted(() => {
      map.value = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v11",
        center: [-6.25, 53.35],
        zoom: 11,
      });

      marker.value = new mapboxgl.Marker({ draggable: true });

      map.value.on("click", function (e) {
        marker.value.setLngLat(e.lngLat).addTo(map.value);
        locate2(e.lngLat);
      });

      marker.value.on("dragend", function (e) {
        locate2(e.target._lngLat);
      });
    });

    watch(props.address, (o) => {
      locate1(o);
    });

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
          marker.value.setLngLat(f.center).addTo(map.value);
          map.value.jumpTo({ center: f.center, zoom: 16 });
          context.emit("marker-set", null, f.center[0], f.center[1]);
        });
    }

    function locate2({ lng, lat }) {
      const query = new URLSearchParams({
        access_token: mapboxgl.accessToken,
        types: "address",
        country: "ie",
      });

      fetch(geo_url + `${lng},${lat}.json?` + query.toString())
        .then((res) => res.json())
        .then((data) => {
          if (!data || !data.features || !data.features.length) return;

          const addr1 = { street: data.features[0].text };
          for (let c of data.features[0].context) {
            if (c.id.startsWith("postcode.")) addr1.postcode = c.text;
            if (c.id.startsWith("region.")) addr1.county = c.text;
            if (c.id.startsWith("place.")) addr1.town = c.text;
          }

          context.emit("marker-set", addr1, lng, lat);
        });
    }

    return {};
  },
};
</script>

<style scoped>
#map {
  width: 100%;
  height: 400px;
}

@media (min-width: 768px) {
  #map {
    height: 450px;
  }
}
</style>
