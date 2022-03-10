<template>
  <div class="map_wrapper">
    <div id="map"></div>
  </div>
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

    mapboxgl.accessToken =
      "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";

    onMounted(() => {
      map.value = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v11",
        center: [props.center.lng, props.center.lat],
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
      const query = new URLSearchParams({
        types: "address",
        country: "ie",
        region: o.county,
        postcode: o.postcode,
        place: o.town,
        access_token: mapboxgl.accessToken,
        limit: 1,
      });

      const str = [o.postcode, o.county, o.town, o.address].join(" ");
      const url =
        "https://api.mapbox.com/geocoding/v5/mapbox.places/" +
        encodeURIComponent(str) +
        ".json?" +
        query.toString();

      fetch(url)
        .then((res) => res.json())
        .then((data) => {
          if (data && data.features && data.features.length > 0) {
            const f = data.features[0];
            marker.value.setLngLat(f.center).addTo(map.value);
            map.value.jumpTo({ center: f.center, zoom: 16 });
          } else {
            console.log("Nothing");
          }
        });
    }

    function locate2({ lng, lat }) {
      const query = new URLSearchParams({
        types: "address",
        country: "ie",
        access_token: mapboxgl.accessToken,
      });

      const url2 =
        "https://api.mapbox.com/geocoding/v5/mapbox.places/" +
        lng +
        "," +
        lat +
        ".json?" +
        query.toString();

      fetch(url2)
        .then((res) => res.json())
        .then((data) => {
          if (!data || !data.features) return;

          const addr1 = { street: data.features[0].text };
          for (let c of data.features[0].context) {
            if (c.id.startsWith("postcode.")) addr1.postcode = c.text;
            if (c.id.startsWith("region.")) addr1.county = c.text;
            if (c.id.startsWith("place.")) addr1.town = c.text;
          }

          context.emit("marker-set", addr1);
        });
    }

    return {};
  },
};
</script>

<style scoped>
.map_wrapper {
  height: 550px;
}
#map {
  height: 100%;
  width: 100%;
}
</style>
