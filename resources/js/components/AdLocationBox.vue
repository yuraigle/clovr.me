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
          :value="address1.location"
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
            <span v-if="address1.postcode" class="me-2">
              Postcode: {{ address1.postcode }}
            </span>
            <span v-if="address1.county" class="me-2">
              County: {{ address1.county }}
            </span>
            <span v-if="address1.town"> Town: {{ address1.town }} </span>
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
  emits: ["update:address", "update:coords"],

  setup(props, { emit }) {
    const map = reactive({
      obj: undefined,
      marker: new mapboxgl.Marker({ draggable: true }),
      shown: false,
    });

    const address1 = reactive(props.address);

    onMounted(() => {
      console.log(props.coords);

      const places1 = places({
        // appId: "<YOUR_PLACES_APP_ID>",
        // apiKey: "<YOUR_PLACES_API_KEY>",
        container: document.querySelector("#address-input"),
        countries: ["ie"],
        type: "address",
      });

      places1.on("clear", () => {
        address1.postcode = "";
        address1.county = "";
        address1.town = "";
        address1.location = "";
        map.marker.setLngLat({ lng: null, lat: null });
      });

      places1.on("change", (e) => {
        const s = e.suggestion;
        address1.postcode = s.postcode;
        address1.county = s.county;
        address1.town = s.city;
        address1.location = s.value;
        emit("update:address", address1);

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
        emit("update:coords", e.lngLat);
      });

      // hidden-resize bugfix
      map.obj.on("resize", function (e) {
        if (!map.shown) {
          map.obj.remove();
          map.obj = undefined;
        }
      });

      console.log(props.coords);

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
      address1,
      map,
      toggleMap,
    };
  },
};
</script>

<style scoped>
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

<style>
.ap-icon-pin {
  display: none;
}

#address-input::-webkit-search-cancel-button {
  display: none;
}
</style>
