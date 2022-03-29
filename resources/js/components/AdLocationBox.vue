<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Location</div>
      <div class="card-body">
        <input
          type="search"
          id="address-input"
          placeholder="Search for a place..."
          class="form-control"
          :class="{ 'is-invalid': errors.location.$error }"
          :value="address.location"
          @input="$emit('update:location', $event.target.value)"
        />
        <span
          class="invalid-feedback"
          :class="{ 'd-block': errors.location.$error }"
          v-if="errors.location.$error"
        >
          {{ errors.location.$errors[0].$message }}
        </span>

        <div class="w-100" v-if="!map.shown">
          <button type="button" class="btn btn-sm btn-link" @click="toggleMap(true)">
            Show the map
            <i class="fa-solid fa-chevron-down"></i>
          </button>
        </div>

        <div class="w-100" :class="{ 'd-none': !map.shown }">
          <p class="text-center mt-1 mb-1">
            <span v-if="address.postcode" class="me-2">
              Postcode: {{ address.postcode }}
            </span>
            <span v-if="address.county" class="me-2"> County: {{ address.county }} </span>
            <span v-if="address.town"> Town: {{ address.town }} </span>
          </p>

          <div id="map" class="mt-2"></div>

          <p class="text-center text-muted mt-1 mb-0">
            <small>Drag the marker and point the exact location.</small>
          </p>

          <div class="d-flex">
            <button
              type="button"
              class="btn btn-sm btn-link me-auto"
              @click="toggleMap(false)"
            >
              Hide the map
              <i class="fa-solid fa-chevron-up"></i>
            </button>

            <button
              type="button"
              class="btn btn-sm btn-outline-success"
              @click="toggleMap(false)"
              v-if="map.marker._lngLat && map.marker._lngLat.lng"
            >
              <i class="fa-solid fa-check"></i>
              Yes, it's the correct location
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted } from "vue";

mapboxgl.accessToken =
  "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";

export default {
  props: ["address", "coords", "errors"],

  setup() {
    const map = reactive({
      obj: undefined,
      marker: new mapboxgl.Marker({ draggable: true }),
      shown: false,
    });

    onMounted(() => {
      const places1 = places({
        // appId: "<YOUR_PLACES_APP_ID>",
        // apiKey: "<YOUR_PLACES_API_KEY>",
        container: document.querySelector("#address-input"),
        countries: ["ie"],
        type: "address",
      });
      places1.on("clear", () => {
        address.postcode = "";
        address.county = "";
        address.town = "";
        address.location = "";
        map.marker.setLngLat({ lng: null, lat: null });
      });
      places1.on("change", (e) => {
        const s = e.suggestion;
        address.postcode = s.postcode;
        address.county = s.county;
        address.town = s.city;
        address.location = s.value;

        map.marker.setLngLat(s.latlng);
        if (map.obj) {
          map.marker.addTo(map.obj);
          map.obj.jumpTo({ center: s.latlng, zoom: 16 });
        }
      });
    });

    function mountMap() {
      map.obj = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v11",
        center: [-6.29726611776664, 53.34677576650242],
        zoom: 11,
      });

      map.obj.on("click", function (e) {
        map.marker.setLngLat(e.lngLat).addTo(map.obj);
      });

      // hidden-resize bugfix
      map.obj.on("resize", function (e) {
        if (!map.shown) {
          map.obj.remove();
          map.obj = undefined;
        }
      });

      if (map.marker._lngLat) {
        map.marker.addTo(map.obj);
        map.obj.jumpTo({ center: map.marker._lngLat, zoom: 16 });
      }
    }

    function toggleMap(v) {
      map.shown = v;
      if (v && !map.obj) {
        setTimeout(() => mountMap(), 100);
      }
    }

    return {
      map,
      toggleMap,
    };
  },
};
</script>
