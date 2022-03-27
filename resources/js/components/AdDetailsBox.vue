<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Property Details {{ category }}</div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-6 mb-2">
            <label for="price" class="form-label">
              <span v-if="[2, 3, 5].includes(category)">Rent:</span>
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

          <div class="col-sm-6 mb-2" v-if="[2, 3, 5].includes(category)">
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
import { watch } from "vue";
import CurrencyInput from "./CurrencyInput.vue";

export default {
  props: ["category", "description", "price", "price_freq", "errors"],
  emits: ["update:price", "update:price_freq", "update:description"],
  components: { CurrencyInput },

  setup(props, { emit }) {
    watch(
      () => props.price,
      (val) => {
        emit("update:price", val);
      }
    );

    return {};
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
