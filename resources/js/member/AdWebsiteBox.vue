<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Website Link</div>
      <div class="card-body">
        <div class="form-check">
          <label class="form-check-label">
            <input
              class="form-check-input"
              type="checkbox"
              :checked="has_www"
              @input="$emit('update:has_www', $event.target.checked)"
            />
            Include a link to your website for &euro;5.00
          </label>
        </div>

        <input
          type="text"
          class="form-control"
          :class="{ 'is-invalid': errors.www.$error }"
          :disabled="!has_www"
          :value="www"
          @input="$emit('update:www', $event.target.value)"
          placeholder="https://"
        />

        <span class="invalid-feedback" v-if="errors.www.$error">
          {{ errors.www.$errors[0].$message }}
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["has_www", "www", "errors"],
  emits: ["update:has_www", "update:www"],

  setup() {
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