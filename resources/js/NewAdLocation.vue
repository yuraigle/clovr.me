<template>
  <div class="d-flex d-flex-row mb-4">
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

    <div class="ms-1">
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

    <div class="ms-1">
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

    <div class="flex-grow-1 ms-1">
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

    <div class="ms-1">
      <button class="btn btn-outline-secondary" type="button" @click="searchAddress">
        <i class="fa-solid fa-location-arrow"></i>
      </button>
    </div>
  </div>

  <div class="w-100">
    <Mapbox :address="mapData.address" :center="mapData.center" @marker-set="markerSet" />
  </div>
</template>

<script>
import { reactive } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength } from "@vuelidate/validators";
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
      address: {
        postcode: "",
        county: "",
        town: "",
        street: "",
      },
      center: {
        lng: -6.25,
        lat: 53.35,
      },
    });

    function searchAddress() {
      this.v$.$validate().then((res) => {
        if (res) {
          Object.assign(mapData.address, address);
        }
      });
    }

    function markerSet(m) {
      address.postcode = m.postcode;
      address.county = m.county;
      address.town = m.town;
      address.street = m.street;
    }

    return {
      address: address,
      mapData: mapData,
      v$,
      searchAddress,
      markerSet,
    };
  },

  validations: () => ({
    address: {
      postcode: {
        max: maxLength(3),
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
