<template>
  <div class="w-100 mt-2 mb-2">
    <div class="card">
      <div class="card-header">Ad Title</div>
      <div class="card-body">
        <input
          type="text"
          class="form-control"
          :class="{ 'is-invalid': errors.title.$error }"
          :value="title"
          @input="handleInput"
        />

        <span class="invalid-feedback" v-if="errors.title.$error">
          {{ errors.title.$errors[0].$message }}
        </span>

        <div class="form-check mt-3">
          <label class="form-check-label">
            <input
              class="form-check-input"
              type="checkbox"
              :checked="bold"
              @input="handleCheckbox"
            />
            Make it outstanding for &euro;10.00
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["title", "bold", "errors"],
  emits: ["update:title", "update:bold"],

  setup(_, { emit }) {
    function handleInput(e) {
      emit("update:title", e.target.value);
    }

    function handleCheckbox(e) {
      emit("update:bold", e.target.checked);
    }

    return {
      handleInput,
      handleCheckbox,
    };
  },
};
</script>
