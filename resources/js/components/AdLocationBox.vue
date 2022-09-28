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

        <div class="w-100" v-if="!shown">
          <button type="button" class="btn btn-sm btn-link" @click="toggleMap(true)">
            Show the map
            <i class="fa-solid fa-chevron-down"></i>
          </button>
        </div>

        <div class="w-100" :class="{ 'd-none': !shown }">
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
              v-if="address1.lng"
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

export default {
  props: ["address", "errors"],
  emits: ["update:address"],

  setup(props, { emit }) {
    const startCenter = [-6.29726611776664, 53.34677576650242];

    const address1 = reactive(props.address);
    const map = ref(null);
    const marker = ref(new mapboxgl.Marker({ draggable: true }));
    const shown = ref(false);

    marker.value.on("dragend", function (e) {
      address1.lng = e.target._lngLat.lng;
      address1.lat = e.target._lngLat.lat;
      emit("update:address", address1);
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
        address1.postcode = undefined;
        address1.county = undefined;
        address1.town = undefined;
        address1.location = undefined;
        address1.lng = undefined;
        address1.lat = undefined;
        emit("update:address", address1);

        marker.value.remove();
      });

      places1.on("change", (e) => {
        const s = e.suggestion;
        address1.postcode = s.postcode;
        address1.county = s.county;
        address1.town = s.city;
        address1.location = s.value;
        address1.lng = s.latlng.lng;
        address1.lat = s.latlng.lat;
        emit("update:address", address1);

        marker.value.setLngLat(s.latlng);
        if (map.value) {
          marker.value.addTo(map.value);
          map.value.jumpTo({ center: s.latlng, zoom: 16 });
        }
      });
    });

    function mountMap() {
      const center = address1.lng ? [address1.lng, address1.lat] : startCenter;
      const zoom = address1.lng ? 16 : 11;
      const style = "mapbox://styles/mapbox/streets-v11";
      map.value = new mapboxgl.Map({ container: "map", style, center, zoom });

      if (address1.lng) {
        marker.value.setLngLat(center).addTo(map.value);
      }

      map.value.on("click", function (e) {
        marker.value.setLngLat(e.lngLat).addTo(map.value);
        address1.lng = e.lngLat.lng;
        address1.lat = e.lngLat.lat;
        emit("update:address", address1);
      });

      // hidden-resize bugfix
      map.value.on("resize", function () {
        if (!shown.value) {
          map.value.remove();
          map.value = undefined;
        }
      });
    }

    function toggleMap(v) {
      shown.value = v;
      if (v && !map.value) {
        setTimeout(() => mountMap(), 100);
      }
    }

    return {
      address1,
      marker,
      shown,
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
