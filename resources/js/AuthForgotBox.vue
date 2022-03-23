<template>
  <div class="card shadow-sm bg-light mt-4 mb-4 p-4">
    <form method="post">
      <p>
        Enter your user account's verified email address and we will send you a
        password reset instructions.
      </p>
      <div class="mb-2">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          id="email"
          v-model="email"
          class="form-control"
          :class="{ 'is-invalid': v$['email'].$error }"
        />
        <span class="invalid-feedback" v-if="v$['email'].$error">
          {{ v$["email"].$errors[0].$message }}
        </span>
      </div>

      <div class="mb-4">
        <button
          type="button"
          class="btn btn-danger btn-lg w-100 bg-gradient"
          @click="submitForm"
        >
          Reset password
        </button>
      </div>

      <div class="mb-2 text-end">
        <a href="/login" class="btn btn-link">Cancel</a>
      </div>
    </form>
  </div>
</template>

<script>
import { ref } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required, helpers } from "@vuelidate/validators";

export default {
  setup() {
    const email = ref();
    const loading = ref(false);
    const v$ = useVuelidate();

    function submitForm() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;
          loading.value = false;
        }
      });
    }

    return {
      email,
      loading,
      v$,
      submitForm,
    };
  },

  validations: () => ({
    email: {
      required: helpers.withMessage("Required", required),
      max: helpers.withMessage("Too long", maxLength(50)),
    },
  }),
};
</script>

<style scoped>
.card {
  max-width: 450px;
  margin: 0 auto;
}
</style>
