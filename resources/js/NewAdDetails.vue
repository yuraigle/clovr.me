<template>
  <form method="post" class="row">
    <div class="w-100 mt-2 mb-2">
      <div class="card">
        <div class="card-header">Category</div>
        <div class="card-body">
          <select
            v-model="details.category_id"
            class="form-control"
            :class="{ 'is-invalid': v$['details'].category_id.$error }"
          >
            <option value="">Please select...</option>
            <option value="1">Property For Sale</option>
            <option value="2">Property To Rent</option>
            <option value="3">Property To Share</option>
            <option value="4">Parking &amp; Garage For Sale</option>
            <option value="5">Parking &amp; Garage To Rent</option>
          </select>
          <span
            class="invalid-feedback"
            v-if="v$['details'].category_id.$error"
          >
            {{ v$["details"].category_id.$errors[0].$message }}
          </span>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2">
      <div class="card">
        <div class="card-header">Ad Title</div>
        <div class="card-body">
          <input
            type="text"
            v-model="details.title"
            class="form-control"
            :class="{ 'is-invalid': v$['details'].title.$error }"
          />
          <span class="invalid-feedback" v-if="v$['details'].title.$error">
            {{ v$["details"].title.$errors[0].$message }}
          </span>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2">
      <div class="card">
        <div class="card-header">Location</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-1 pee-05">
              <div class="d-flex d-flex-row">
                <div>
                  <input
                    type="text"
                    v-model="address.postcode"
                    class="form-control"
                    :class="{ 'is-invalid': v$['address'].postcode.$error }"
                    placeholder="Postal Code"
                    style="width: 110px"
                  />
                  <span
                    class="invalid-feedback"
                    v-if="v$['address'].postcode.$error"
                  >
                    {{ v$["address"].postcode.$errors[0].$message }}
                  </span>
                </div>

                <div class="flex-grow-1 ms-1">
                  <input
                    type="text"
                    v-model="address.county"
                    class="form-control"
                    :class="{ 'is-invalid': v$['address'].county.$error }"
                    placeholder="County"
                  />
                  <span
                    class="invalid-feedback"
                    v-if="v$['address'].county.$error"
                  >
                    {{ v$["address"].county.$errors[0].$message }}
                  </span>
                </div>

                <div class="flex-grow-1 ms-1">
                  <input
                    type="text"
                    v-model="address.town"
                    class="form-control"
                    :class="{ 'is-invalid': v$['address'].town.$error }"
                    placeholder="Town"
                  />
                  <span
                    class="invalid-feedback"
                    v-if="v$['address'].town.$error"
                  >
                    {{ v$["address"].town.$errors[0].$message }}
                  </span>
                </div>
              </div>
            </div>

            <div class="col-md-6 pss-05">
              <div class="d-flex d-flex-row">
                <div class="flex-grow-1">
                  <input
                    type="text"
                    v-model="address.street"
                    class="form-control"
                    :class="{ 'is-invalid': v$['address'].street.$error }"
                    placeholder="Address"
                  />
                  <span
                    class="invalid-feedback"
                    v-if="v$['address'].street.$error"
                  >
                    {{ v$["address"].street.$errors[0].$message }}
                  </span>
                </div>

                <div class="flex-shrink-1 ms-1">
                  <button
                    class="btn btn-outline-dark"
                    type="button"
                    title="Find on the map"
                    @click="searchAddress"
                  >
                    <i class="fa-solid fa-location-arrow"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="w-100" v-if="!map.shown">
            <button
              type="button"
              class="btn btn-sm btn-link"
              @click="toggleMap(true)"
            >
              Show on the map
              <i class="fa-solid fa-chevron-down"></i>
            </button>
          </div>

          <div class="w-100" :class="{ 'd-none': !map.shown }">
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
                v-if="map.marker._lngLat"
              >
                <i class="fa-solid fa-check"></i>
                Yes, it's the correct location
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2">
      <div class="card">
        <div class="card-header">Property Details</div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6 mb-2">
              <label for="price" class="form-label">
                <span v-if="['2', '3', '5'].includes(details.category_id)"
                  >Rent:</span
                >
                <span v-else>Price:</span>
              </label>
              <CurrencyInput
                id="price"
                v-model="details.price"
                class="form-control"
                :class="{ 'is-invalid': v$['details'].price.$error }"
              />
              <span class="invalid-feedback" v-if="v$['details'].price.$error">
                {{ v$["details"].price.$errors[0].$message }}
              </span>
            </div>

            <div
              class="col-sm-6 mb-2"
              v-if="['2', '3', '5'].includes(details.category_id)"
            >
              <label for="price_freq" class="form-label">Rent period:</label>

              <div
                class="form-check"
                :class="{ 'is-invalid': v$['details'].price_freq.$error }"
              >
                <input
                  type="radio"
                  id="price_freq_m"
                  name="price_freq"
                  v-model="details.price_freq"
                  class="form-check-input float-none me-1"
                  :class="{ 'is-invalid': v$['details'].price_freq.$error }"
                  value="per_month"
                />
                <label
                  class="form-check-label me-4 ps-1 pe-2"
                  for="price_freq_m"
                >
                  Monthly
                </label>

                <input
                  type="radio"
                  id="price_freq_w"
                  name="price_freq"
                  v-model="details.price_freq"
                  class="form-check-input float-none ms-2 me-1"
                  :class="{ 'is-invalid': v$['details'].price_freq.$error }"
                  value="per_week"
                />
                <label
                  class="form-check-label me-4 ps-1 pe-2"
                  for="price_freq_w"
                >
                  Weekly
                </label>
              </div>

              <span
                class="invalid-feedback"
                v-if="v$['details'].price_freq.$error"
              >
                {{ v$["details"].price_freq.$errors[0].$message }}
              </span>
            </div>

            <div class="col-sm-6 mb-2" v-if="details.category_id > 0">
              <label for="property_type" class="form-label"
                >Property Type:</label
              >
              <select
                id="property_type"
                v-model="details.property_type"
                class="form-control"
                :class="{ 'is-invalid': v$['details'].property_type.$error }"
              >
                <option value="">Please select...</option>
                <option value="flat" v-if="details.category_id < 4">
                  Flat
                </option>
                <option value="house" v-if="details.category_id < 4">
                  House
                </option>
                <option value="other" v-if="details.category_id < 4">
                  Other
                </option>
                <option value="garage" v-if="details.category_id >= 4">
                  Garage
                </option>
                <option value="parking" v-if="details.category_id >= 4">
                  Parking space
                </option>
              </select>
              <span
                class="invalid-feedback"
                v-if="v$['details'].property_type.$error"
              >
                {{ v$["details"].property_type.$errors[0].$message }}
              </span>
            </div>

            <div
              class="col-sm-6 mb-4"
              v-if="['1', '2'].includes(details.category_id)"
            >
              <label for="num_beds" class="form-label">No. of Bedrooms:</label>
              <select
                id="num_beds"
                v-model="details.num_beds"
                class="form-control"
                :class="{ 'is-invalid': v$['details'].num_beds.$error }"
              >
                <option value="">Please select...</option>
                <option value="0">Studio</option>
                <option v-for="index in 10" :key="index" :value="index">
                  {{ index }}
                </option>
              </select>
              <span
                class="invalid-feedback"
                v-if="v$['details'].num_beds.$error"
              >
                {{ v$["details"].num_beds.$errors[0].$message }}
              </span>
            </div>

            <div
              class="col-sm-6 mb-2"
              v-if="['3'].includes(details.category_id)"
            >
              <label for="room_type" class="form-label">Room type:</label>
              <select
                id="room_type"
                v-model="details.room_type"
                class="form-control"
                :class="{ 'is-invalid': v$['details'].room_type.$error }"
              >
                <option value="">Please select...</option>
                <option value="single">Single room</option>
                <option value="double">Double room</option>
                <option value="twin">Twin room</option>
                <option value="triple">Triple room</option>
                <option value="shared">Shared room</option>
                <option value="couch">Couch Surf</option>
              </select>
              <span
                class="invalid-feedback"
                v-if="v$['details'].room_type.$error"
              >
                {{ v$["details"].room_type.$errors[0].$message }}
              </span>
            </div>
          </div>
          <div class="row mt-4 mb-2">
            <label for="description" class="form-label"> Description: </label>

            <div class="col-lg-9 col-md-8">
              <textarea
                id="description"
                v-model="details.description"
                class="form-control"
                :class="{ 'is-invalid': v$['details'].description.$error }"
                rows="6"
              ></textarea>
              <span
                class="invalid-feedback"
                v-if="v$['details'].description.$error"
              >
                {{ v$["details"].description.$errors[0].$message }}
              </span>
            </div>

            <div class="col-lg-3 col-md-4 lh-sm">
              <small class="text-muted">
                Enter as much information possible. Ads with detailed and longer
                descriptions get more views and replies!
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2">
      <div class="card">
        <div class="card-header">Pictures</div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-9 col-md-8">
              <img
                v-for="p in pictures"
                :key="p"
                :src="'/images/' + p.replace('x_', 's_')"
                class="img-thumbnail me-1 mb-1"
                alt="uploaded image"
              />

              <label
                class="btn btn-link text-decoration-none ps-3"
                :class="{ disabled: uploading }"
                style="height: 100px"
              >
                <span style="line-height: 85px">
                  <i class="fa-solid fa-spinner" v-if="uploading"></i>
                  <i class="fa-solid fa-camera-retro" v-else></i>
                  Add image
                  <input
                    type="file"
                    class="d-none"
                    accept="image/*"
                    @change="onFileAdd"
                  />
                </span>
              </label>
            </div>
            <div class="col-lg-3 col-md-4 lh-sm">
              <small class="text-muted">
                You can add up to <strong>10 images</strong>. Upload as many
                clear images as possible; this will get your ad more views and
                replies!
              </small>
            </div>
          </div>

          <div class="d-md-flex border-top pt-3 mt-2">
            <label class="col-form-label me-4" for="yt_link">
              Add a YouTube video link:
            </label>
            <div class="flex-grow-1">
              <div class="input-group">
                <span class="input-group-text"
                  ><i class="fa-brands fa-youtube"></i
                ></span>
                <input
                  class="form-control"
                  type="text"
                  id="yt_link"
                  placeholder="https://www.youtube.com/watch?v=K69tbUo3vGs"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2 text-end">
      <button
        type="button"
        class="btn btn-primary"
        :class="{ disabled: loading }"
        @click="submitForm"
        style="width: 80px"
      >
        Next
        <i class="fa-solid fa-spinner" v-if="loading"></i>
        <i class="fa-solid fa-chevron-right" v-else></i>
      </button>
    </div>
  </form>
</template>

<script>
import { reactive, ref } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, minLength, required, helpers } from "@vuelidate/validators";
import CurrencyInput from "./components/CurrencyInput.vue";

mapboxgl.accessToken =
  "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";

export default {
  components: { CurrencyInput },

  setup() {
    const details = reactive({
      category_id: undefined,
      title: undefined,
      price: undefined,
      property_type: undefined,
      num_beds: undefined,
      description: undefined,
      price_freq: undefined,
      room_type: undefined,
    });

    const address = reactive({
      postcode: "",
      county: "",
      town: "",
      street: "",
    });

    const map = reactive({
      obj: undefined,
      marker: new mapboxgl.Marker({ draggable: true }),
      shown: false,
    });

    const pictures = ref([]);

    const loading = ref(false);
    const uploading = ref(false);
    const v$ = useVuelidate();
    const geo_url = "https://api.mapbox.com/geocoding/v5/mapbox.places/";

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

    function searchAddress() {
      this.v$.address.$validate().then((res) => {
        if (res) {
          toggleMap(true);

          const str = [
            address.postcode,
            address.county,
            address.town,
            address.street,
          ].join(" ");

          const query = new URLSearchParams({
            access_token: mapboxgl.accessToken,
            types: "address",
            country: "ie",
            region: address.county,
            postcode: address.postcode,
            place: address.town,
            limit: 1,
          });

          fetch(geo_url + encodeURIComponent(str) + ".json?" + query.toString())
            .then((res) => res.json())
            .then((data) => {
              if (!data || !data.features || !data.features.length) return;
              const f = data.features[0];
              map.marker.setLngLat(f.center);

              if (map.obj) {
                map.marker.addTo(map.obj);
                map.obj.jumpTo({ center: f.center, zoom: 16 });
              }
            });
        }
      });
    }

    // https://webdevblog.ru/zagruzka-fajlov-s-pomoshhju-vuejs-i-axios/
    function onFileAdd(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (files.length) {
        uploading.value = true;

        const formData = new FormData();
        formData.append("pic", files[0]);

        fetch("/image-upload", {
          method: "POST",
          body: formData,
        })
          .then((resp) => resp.json())
          .then((res) => {
            pictures.value.push(res.location);
          })
          .catch((error) => console.error("Error:", error))
          .finally(() => (uploading.value = false));
      }
    }

    function submitForm() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;

          const postData = Object.assign(
            {},
            this.details,
            this.address,
            this.map.marker._lngLat
          );

          const csrf = document.querySelector(
            'meta[name="csrf-token"]'
          ).content;
          const formData = new FormData();
          for (let key in postData) {
            formData.append(key, postData[key]);
          }

          fetch("/new-ad", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrf },
            body: formData,
          })
            .then((resp) => resp.json())
            .then((result) => {
              console.log(result);
            })
            .catch((error) => console.error("Error:", error))
            .finally(() => (loading.value = false));
        }
      });
    }

    return {
      details,
      address,
      pictures,
      loading,
      uploading,
      map,
      v$,
      toggleMap,
      searchAddress,
      onFileAdd,
      submitForm,
    };
  },

  validations: {
    details: {
      category_id: {
        required: helpers.withMessage("Required", required),
      },
      title: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(100)),
      },
      price: {
        required: helpers.withMessage("Required", required),
      },
      property_type: {},
      num_beds: {},
      description: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(10000)),
      },
      price_freq: {}, // todo: requiredIf
      room_type: {},
    },
    address: {
      postcode: {
        min: helpers.withMessage("3 symbols", minLength(3)),
        max: helpers.withMessage("3 symbols", maxLength(3)),
      },
      county: {
        max: maxLength(20),
      },
      town: {
        required: helpers.withMessage("Required", required),
        max: maxLength(20),
      },
      street: {
        required: helpers.withMessage("Required", required),
        max: maxLength(50),
      },
    },
  },
};
</script>

<style scoped>
form {
  max-width: 900px;
  margin: 0 auto;
}
.form-check {
  padding-top: 0.375rem;
  padding-bottom: 0.375rem;
  border: 1px solid transparent;
}

#map {
  width: 100%;
  height: 400px;
  position: relative;
  overflow: hidden;
}

@media (min-width: 768px) {
  .pss-05 {
    padding-left: 2px;
  }
  .pee-05 {
    padding-right: 2px;
  }
  #map {
    height: 450px;
  }
}
</style>
