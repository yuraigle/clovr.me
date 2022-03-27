<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Property Details {{ cid }}</div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-6 mb-2">
            <label for="price" class="form-label">
              <span v-if="[2, 3, 5].includes(cid)">Rent:</span>
              <span v-else>Price:</span>
            </label>
            <CurrencyInput
              id="price"
              class="form-control"
              :class="{ 'is-invalid': errors.price.$error }"
              v-model="price"
            />
            <span class="invalid-feedback" v-if="errors.price.$error">
              {{ errors.price.$errors[0].$message }}
            </span>
          </div>

          <div class="col-sm-6 mb-2" v-if="[2, 3, 5].includes(cid)">
            <label for="price_freq" class="form-label">Rent period:</label>
            <div
              class="form-check"
              :class="{ 'is-invalid': errors.price_freq.$error }"
            >
              <input
                type="radio"
                id="price_freq_m"
                name="price_freq"
                class="form-check-input float-none me-1"
                :class="{ 'is-invalid': errors.price_freq.$error }"
                :checked="price_freq === 'per_month'"
                @change="$emit('update:price_freq', $event.target.value)"
                value="per_month"
              />
              <label class="form-check-label me-4 ps-1 pe-2" for="price_freq_m">
                Monthly
              </label>
              <input
                type="radio"
                id="price_freq_w"
                name="price_freq"
                class="form-check-input float-none ms-2 me-1"
                :class="{ 'is-invalid': errors.price_freq.$error }"
                :checked="price_freq === 'per_week'"
                @change="$emit('update:price_freq', $event.target.value)"
                value="per_week"
              />
              <label class="form-check-label me-4 ps-1 pe-2" for="price_freq_w">
                Weekly
              </label>
            </div>
            <span class="invalid-feedback" v-if="errors.price_freq.$error">
              {{ errors.price_freq.$errors[0].$message }}
            </span>
          </div>

          <div class="col-sm-6 mb-2" v-if="cid > 0">
            <label for="property_type" class="form-label">Property Type:</label>
            <select
              id="property_type"
              class="form-control"
              :class="{ 'is-invalid': errors.property_type.$error }"
              :value="property_type"
              @change="$emit('update:property_type', $event.target.value)"
            >
              <option value="">Please select...</option>
              <option value="flat" v-if="cid < 4">Flat</option>
              <option value="house" v-if="cid < 4">House</option>
              <option value="other" v-if="cid < 4">Other</option>
              <option value="garage" v-if="cid >= 4">Garage</option>
              <option value="parking" v-if="cid >= 4">Parking space</option>
            </select>
            <span class="invalid-feedback" v-if="errors.property_type.$error">
              {{ errors.property_type.$errors[0].$message }}
            </span>
          </div>

          <div class="col-sm-6 mb-4" v-if="[1, 2].includes(cid)">
            <label for="num_beds" class="form-label">No. of Bedrooms:</label>
            <select
              id="num_beds"
              class="form-control"
              :class="{ 'is-invalid': errors.num_beds.$error }"
              :value="num_beds"
              @change="$emit('update:num_beds', $event.target.value)"
            >
              <option value="">Please select...</option>
              <option value="0">Studio</option>
              <option v-for="index in 10" :key="index" :value="index">
                {{ index }}
              </option>
            </select>
            <span class="invalid-feedback" v-if="errors.num_beds.$error">
              {{ errors.num_beds.$errors[0].$message }}
            </span>
          </div>

          <div class="col-sm-6 mb-2" v-if="[3].includes(cid)">
            <label for="room_type" class="form-label">Room type:</label>
            <select
              id="room_type"
              class="form-control"
              :class="{ 'is-invalid': errors.room_type.$error }"
              :value="room_type"
              @change="$emit('update:room_type', $event.target.value)"
            >
              <option value="">Please select...</option>
              <option value="single">Single room</option>
              <option value="double">Double room</option>
              <option value="twin">Twin room</option>
              <option value="triple">Triple room</option>
              <option value="shared">Shared room</option>
              <option value="couch">Couch Surf</option>
            </select>
            <span class="invalid-feedback" v-if="errors.room_type.$error">
              {{ errors.room_type.$errors[0].$message }}
            </span>
          </div>
        </div>

        <div class="row mt-4 mb-2">
          <label for="description" class="form-label"> Description: </label>

          <div class="col-lg-9 col-md-8">
            <textarea
              id="description"
              class="form-control"
              :class="{ 'is-invalid': errors.description.$error }"
              :value="description"
              @input="$emit('update:description', $event.target.value)"
              rows="6"
            ></textarea>

            <span class="invalid-feedback" v-if="errors.description.$error">
              {{ errors.description.$errors[0].$message }}
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
</template>

<script>
import { watch, computed } from "vue";
import CurrencyInput from "./CurrencyInput.vue";

export default {
  props: [
    "category",
    "price",
    "price_freq",
    "property_type",
    "num_beds",
    "room_type",
    "description",
    "errors",
  ],
  emits: [
    "update:price",
    "update:price_freq",
    "update:property_type",
    "update:num_beds",
    "update:room_type",
    "update:description",
  ],
  components: { CurrencyInput },

  setup(props, { emit }) {
    const cid = computed(() => parseInt(props.category));

    watch(
      () => props.price,
      (val) => {
        emit("update:price", val);
      }
    );

    return {
      cid,
    };
  },
};
</script>

<style scoped>
.form-check {
  padding-top: 0.375rem;
  padding-bottom: 0.375rem;
  border: 1px solid transparent;
}
</style>
