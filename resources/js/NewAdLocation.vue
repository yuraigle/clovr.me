<template>
  <form method="post">
    <p class="text-center mt-2 mb-1">Search by address details:</p>

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
            <span class="invalid-feedback" v-if="v$['address'].postcode.$error">
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
            <span class="invalid-feedback" v-if="v$['address'].county.$error">
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
            <span class="invalid-feedback" v-if="v$['address'].town.$error">
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
            <span class="invalid-feedback" v-if="v$['address'].street.$error">
              {{ v$["address"].street.$errors[0].$message }}
            </span>
          </div>

          <div class="flex-shrink-1 ms-1">
            <button
              class="btn btn-outline-primary"
              type="button"
              @click="searchAddress"
            >
              <i class="fa-solid fa-location-arrow"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <p class="text-center mt-2 mb-1">...or just click on the map:</p>

    <div class="w-100">
      <Mapbox
        :address="mapData.address"
        :center="mapData.center"
        @marker-set="markerSet"
      />
    </div>

    <div class="text-center mt-2 res-msg">
      <span v-if="mapData.center.lng">
        Is this an accurate location of your home?<br />
        Drag the marker and point the exact location.
      </span>
    </div>

    <div class="d-flex d-flex-row">
      <a href="/new-ad" class="btn btn-outline-secondary me-auto">
        <i class="fa-solid fa-chevron-left"></i>
        Back
      </a>
      <button
        type="button"
        class="btn btn-primary"
        :class="{ disabled: !mapData.center.lng }"
        @click="submitForm"
      >
        Yes, it's the correct location
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>
  </form>
</template>

<script>
import { reactive } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, minLength, helpers } from "@vuelidate/validators";
import Mapbox from "./components/Mapbox.vue";

export default {
  components: { Mapbox },

  setup() {
    const v$ = useVuelidate();

    const address = reactive({
      postcode: "",
      county: "",
      town: "",
      street: "",
    });

    const mapData = reactive({
      address: {},
      center: {},
    });

    function searchAddress() {
      this.v$.$validate().then((res) => {
        if (res) {
          Object.assign(mapData.address, address);
        }
      });
    }

    function markerSet(m, lng, lat) {
      if (m) Object.assign(address, m);
      mapData.center.lng = lng;
      mapData.center.lat = lat;
    }

    function submitForm() {
      this.v$.$validate().then((res) => {
        if (res && mapData.center.lng && mapData.center.lat) {
          console.log("submitted");
        }
      });
    }

    return {
      address: address,
      mapData: mapData,
      searchAddress,
      markerSet,
      submitForm,
      v$,
    };
  },

  validations: () => ({
    address: {
      postcode: {
        min: helpers.withMessage("3 symbols", minLength(3)),
        max: helpers.withMessage("3 symbols", maxLength(3)),
      },

      county: {
        max: maxLength(20),
      },

      town: {
        max: maxLength(20),
      },

      street: {
        max: maxLength(50),
      },
    },
  }),
};
</script>

<style scoped>
form {
  max-width: 850px;
  margin: 0 auto;
}
.res-msg {
  min-height: 50px;
}

@media (min-width: 768px) {
  .pss-05 {
    padding-left: 2px;
  }
  .pee-05 {
    padding-right: 2px;
  }
}
</style>
