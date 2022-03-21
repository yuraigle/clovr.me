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

          <div class="form-check mt-3">
            <label class="form-check-label">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="details.is_bold"
              />
              Make it outstanding for &euro;15.00
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2">
      <div class="card">
        <div class="card-header">Location</div>
        <div class="card-body">
          <input
            type="search"
            id="address-input"
            placeholder="Search for a place..."
            v-model="address.location"
            class="form-control"
            :class="{ 'is-invalid': v$['address'].location.$error }"
          />
          <span
            class="invalid-feedback"
            :class="{ 'd-block': v$['address'].location.$error }"
            v-if="v$['address'].location.$error"
          >
            {{ v$["address"].location.$errors[0].$message }}
          </span>

          <div class="w-100" v-if="!map.shown">
            <button
              type="button"
              class="btn btn-sm btn-link"
              @click="toggleMap(true)"
            >
              Show the map
              <i class="fa-solid fa-chevron-down"></i>
            </button>
          </div>

          <div class="w-100" :class="{ 'd-none': !map.shown }">
            <p class="text-center mt-1 mb-1">
              <span v-if="address.postcode" class="me-2">
                Postcode: {{ address.postcode }}
              </span>
              <span v-if="address.county" class="me-2">
                County: {{ address.county }}
              </span>
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
              <div
                v-for="hash in pictures"
                :key="hash"
                class="d-inline-block img-thumbnail me-1 mb-1"
              >
                <button
                  type="button"
                  class="btn-close"
                  title="Remove"
                  @click="removeImg(hash)"
                >
                  &nbsp;
                </button>
                <img :src="hash2img(hash)" alt="img" />
              </div>

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
                    id="picture1"
                    type="file"
                    class="d-none"
                    accept="image/*"
                    @change="addImg"
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
            <label class="col-form-label me-4" for="youtube">
              Add a YouTube video link:
            </label>
            <div class="flex-grow-1">
              <div class="input-group">
                <span class="input-group-text"
                  ><i class="fa-brands fa-youtube"></i
                ></span>
                <input
                  type="text"
                  v-model="details.youtube"
                  id="youtube"
                  class="form-control"
                  :class="{ 'is-invalid': v$['details'].youtube.$error }"
                  placeholder="https://www.youtube.com/watch?v=K69tbUo3vGs"
                />

                <span
                  class="invalid-feedback"
                  v-if="v$['details'].youtube.$error"
                >
                  {{ v$["details"].youtube.$errors[0].$message }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2">
      <div class="card">
        <div class="card-header">Website Link</div>
        <div class="card-body">
          <div class="form-check">
            <label class="form-check-label">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="details.has_www"
              />
              Include a link to your website for &euro;5.00
            </label>
          </div>

          <input
            type="text"
            v-model="details.www"
            class="form-control"
            :disabled="!details.has_www"
            :class="{ 'is-invalid': v$['details'].www.$error }"
            placeholder="https://"
          />
          <span class="invalid-feedback" v-if="v$['details'].www.$error">
            {{ v$["details"].www.$errors[0].$message }}
          </span>
        </div>
      </div>
    </div>

    <div class="w-100 mt-2 mb-2 text-end">
      <button
        type="button"
        class="btn btn-primary"
        :class="{ disabled: loading }"
        @click="submitForm"
      >
        Next
        <i class="fa-solid fa-spinner" v-if="loading"></i>
        <i class="fa-solid fa-chevron-right" v-else></i>
      </button>
    </div>
  </form>
</template>

<script>
import { reactive, ref, onMounted } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required, url, helpers } from "@vuelidate/validators";
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
      www: undefined,
      youtube: undefined,
      has_www: false,
      is_bold: false,
    });

    const address = reactive({
      postcode: "",
      county: "",
      town: "",
      location: "",
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

    function hash2img(s) {
      return "/images/" + s.substring(0, 4) + "/s_" + s + ".webp";
    }

    function addImg(e) {
      const files = e.target.files || e.dataTransfer.files;
      if (files.length) {
        uploading.value = true;

        const formData = new FormData();
        formData.append("pic", files[0]);

        fetchApi(
          "/image-upload",
          {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrf() },
            body: formData,
          },
          (resp) => pictures.value.push(resp.hash),
          () => {
            uploading.value = false;
            document.getElementById("picture1").value = null;
          }
        );
      }
    }

    function removeImg(hash) {
      for (let i = 0; i < pictures.value.length; i++) {
        if (pictures.value[i] === hash) {
          pictures.value.splice(i, 1);
        }
      }
    }

    function submitForm() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;

          const postData = Object.assign(
            {},
            details,
            address,
            map.marker._lngLat
          );
          const formData = new FormData();
          for (const key in postData) {
            if (postData[key] !== undefined) {
              formData.append(key, postData[key]);
            }
          }
          for (const pic of pictures.value) {
            formData.append("pictures[]", pic);
          }

          fetchApi(
            "/new-ad",
            {
              method: "POST",
              headers: { "X-CSRF-TOKEN": csrf() },
              body: formData,
            },
            (resp) => (window.location.href = "/activate?id=" + resp.id),
            () => (loading.value = false)
          );
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
      addImg,
      removeImg,
      hash2img,
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
      www: {
        url,
        max: maxLength(500),
      },
      youtube: {
        url,
        yt2: helpers.withMessage(
          "Not a valid YouTube link",
          helpers.regex(/^https?:\/\/(www\.)?youtube\.com\/watch/)
        ),
        max: maxLength(100),
      },
    },
    address: {
      location: {
        required,
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

.img-thumbnail {
  position: relative;
}
.img-thumbnail > .btn-close {
  background-color: #8a848d;
  position: absolute;
  top: 0;
  right: 0;
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

<style>
.ap-icon-pin {
  display: none;
}

#address-input::-webkit-search-cancel-button {
  display: none;
}
</style>
