<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Category</div>
      <div class="card-body">
        <select
          class="form-control"
          :class="{ 'is-invalid': errors.$error }"
          :disabled="!editable"
          :value="category_id"
          @change="$emit('update:category_id', $event.target.value)"
        >
          <option value="">Please select...</option>
          <option value="1">Property For Sale</option>
          <option value="2">Property To Rent</option>
          <option value="3">Property To Share</option>
          <option value="4">Parking &amp; Garage For Sale</option>
          <option value="5">Parking &amp; Garage To Rent</option>
        </select>
        <span class="invalid-feedback" v-if="errors.$error">
          {{ errors.$errors[0].$message }}
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["category_id", "errors", "editable"],

  setup() {
    return {};
  },
};
</script>
