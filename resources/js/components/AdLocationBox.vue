<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Location</div>
      <div class="card-body">

        <div class="row">
          <div v-if="mode === 'line'">
            <p class="mb-0">{{ addressOneLine }}</p>
            <button type="button" class="btn btn-sm btn-link p-0" @click="editAddressDetails">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="16" height="16"
                   viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                   stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"/>
                <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"/>
              </svg>
              Edit address details
            </button>
          </div>

          <div class="col-md-6">
            <div v-if="mode === 'details' || mode === 'input'">
              <label for="location" class="form-label">Address:</label>
              <input
                id="location"
                placeholder="Start typing an address..."
                class="form-control mb-1"
                :class="{ 'is-invalid': errors.location.$error }"
                :value="address1.location"
                @input="handleInputAddress"
                @focusin="addressOptionsShown = true"
                @focusout="handleAddressFocusOut"
              />

              <span class="invalid-feedback" v-if="errors.location.$error">
                {{ errors.location.$errors[0].$message }}
              </span>

              <button
                type="button"
                class="btn btn-sm btn-link p-0"
                @click="editAddressDetails"
                v-if="mode !== 'details'"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="16"
                     height="16"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                     stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"/>
                  <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"/>
                </svg>
                Enter location details manually
              </button>
            </div>

            <div
              v-if="addressOptions && addressOptionsShown"
              class="list-group shadow-lg"
              style="position: absolute; z-index: 1"
            >
              <a
                class="list-group-item list-group-item-action"
                role="button"
                @click="handleSelectAddress(addr)"
                v-for="addr in addressOptions"
                key="{{ addr.id }}"
              >
                {{ addr['place_name'] }}
              </a>
            </div>

            <div v-if="mode === 'details'">
              <label for="town" class="form-label mt-1 mb-0">Town:</label>
              <input
                id="town"
                placeholder="Town"
                class="form-control form-control-sm mb-1"
                :value="address1.town"
              />

              <label for="county" class="form-label mt-1 mb-0">County:</label>
              <input
                id="county"
                placeholder="County / Region"
                class="form-control form-control-sm mb-1"
                :value="address1.county"
              />

              <label for="postcode" class="form-label mt-1 mb-0">Postcode:</label>
              <input
                id="postcode"
                placeholder="ZIP / Postcode"
                class="form-control form-control-sm mb-1"
                :value="address1.postcode"
              />

              <div class="mt-2" v-if="mode === 'details'">
                <button type="button" class="btn btn-link text-success me-2" @click="submitAddressDetails">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="16"
                       height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l5 5l10 -10"/>
                  </svg>

                  Yes, it's the correct location
                </button>
                <button type="button" class="btn btn-link text-warning" @click="resetAddressDetails">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="16" height="16"
                       viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                       stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                  </svg>
                  Reset
                </button>
              </div>
            </div>
          </div>

          <div class="col-md-6" :style="{ display: mode === 'details' ? 'block': 'none' }">
            <p class="form-label text-center text-muted" v-if="map">
              Drag the marker and point the exact location
            </p>
            <div id="map"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {computed, reactive, ref, toRaw} from "vue";

export default {
  props: ["address", "errors", "mode"],
  emits: ["update:address", "validate"],

  setup(props, {emit}) {
    const address1 = reactive(props.address);
    const errors = reactive(props.errors);
    const map = ref(null);
    const marker = ref(null);
    const mode = ref('input'); // line | input | details
    const addressOptions = reactive([]);
    const addressOptionsShown = ref(false);

    if (props.mode) {
      mode.value = props.mode;
    }

    const addressOneLine = computed(() => {
      const parts = [];
      const s = [address1.county ?? '', address1.postcode ?? ''].join(' ').trim();
      if (address1.location) parts.push(address1.location)
      if (address1.town) parts.push(address1.town)
      if (s) parts.push(s);
      return parts.join(', ')
    });

    let t;

    function handleInputAddress(e) {
      address1.location = e.target.value;

      clearTimeout(t);
      t = setTimeout(() => {
        const urlBase = 'https://api.mapbox.com/geocoding/v5/mapbox.places/';
        const urlParams = new URLSearchParams({
          access_token: window.mapboxToken,
          autocomplete: 'true',
          fuzzyMatch: 'false',
          country: 'ie',
          proximity: 'ip',
          language: 'en',
          types: 'address',
        });
        const url = urlBase + encodeURI(e.target.value) + ".json?" + urlParams.toString();

        fetch(url, {})
          .then((r) => r.json().then((d) => ({status: r.status, body: d})))
          .then((result) => {
            if (result.status === 200) {
              addressOptions.length = 0;
              for (const f of result.body.features) {
                addressOptions.push(f);
              }
            }
          })
          .catch((err) => {
            console.error(err);
          });
      }, 1000);
    }

    function handleSelectAddress(f) {
      Object.keys(address1).forEach(k => address1[k] = undefined);

      const fRaw = toRaw(f);
      address1.location = [fRaw.address, fRaw.text].join(' ');
      address1.lng = fRaw.center[0];
      address1.lat = fRaw.center[1];

      for (let v of Object.values(fRaw.context)) {
        if (v.id.match(/^region/)) {
          address1.county = v.text;
        } else if (v.id.match(/^place/)) {
          address1.town = v.text;
        } else if (v.id.match(/^postcode/)) {
          address1.postcode = v.text;
        }
      }

      if (!map.value) {
        setTimeout(() => mountMap(), 100);
      } else {
        centerMap();
      }

      emit("update:address", address1);
      addressOptionsShown.value = false;
      mode.value = 'details';
    }

    function handleAddressFocusOut() {
      setTimeout(() => addressOptionsShown.value = false, 300);
    }

    function mountMap() {
      const townData = JSON.parse(document.querySelector('meta[name="town"]').content);
      const center = address1.lng ? [address1.lng, address1.lat] : [townData.lng, townData.lat];
      const zoom = address1.lng ? 16 : townData.zoom;
      map.value = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/streets-v11",
        accessToken: window.mapboxToken,
        center,
        zoom
      });
      marker.value = new mapboxgl.Marker({draggable: true});

      if (address1.lng) {
        marker.value.setLngLat(center).addTo(map.value);
      }

      map.value.on("click", function (e) {
        marker.value.setLngLat(e.lngLat).addTo(map.value);
        address1.lng = e.lngLat.lng;
        address1.lat = e.lngLat.lat;
        emit("update:address", address1);
      });

      marker.value.on("dragend", function (e) {
        address1.lng = e.target._lngLat.lng;
        address1.lat = e.target._lngLat.lat;
        emit("update:address", address1);
      });
    }

    function centerMap() {
      if (address1.lng) {
        const center = [address1.lng, address1.lat];
        map.value.setCenter(center, {});
        map.value.setZoom(16);
        marker.value.setLngLat(center).addTo(map.value);
      }
    }

    function resetAddressDetails() {
      addressOptions.length = 0;
      Object.keys(address1).forEach(k => address1[k] = undefined);
      mode.value = 'input'
      emit("update:address", address1);
    }

    function editAddressDetails() {
      mode.value = 'details';

      if (!map.value) {
        setTimeout(() => mountMap(), 100);
      } else {
        centerMap();
      }
    }

    function submitAddressDetails() {
      emit("validate", address1);

      if (!errors['$invalid']) {
        mode.value = 'line';
      }
    }

    return {
      mode,
      map,
      marker,
      address1,
      addressOneLine,
      addressOptions,
      addressOptionsShown,
      handleInputAddress,
      handleSelectAddress,
      handleAddressFocusOut,
      editAddressDetails,
      resetAddressDetails,
      submitAddressDetails,
    };
  },
};
</script>

<style scoped>
#map {
  width: 100%;
  position: relative;
  overflow: hidden;
  height: 272px;
}
</style>
