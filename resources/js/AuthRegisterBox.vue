<template>
  <div class="card shadow-sm bg-light mt-4 mb-4 p-4">
    <button type="button" class="btn btn-primary btn-lg w-100">
      <i class="fa-brands fa-facebook-square me-1"></i>
      Sign in with Facebook
    </button>

    <p class="text-center text-muted mt-3 mb-1">or</p>

    <form method="post">
      <div class="mb-2">
        <label for="first_name" class="form-label">First Name</label>
        <input
          type="text"
          id="first_name"
          v-model="first_name"
          class="form-control"
          :class="{ 'is-invalid': v$['first_name'].$error }"
        />
        <span class="invalid-feedback" v-if="v$['first_name'].$error">
          {{ v$["first_name"].$errors[0].$message }}
        </span>
      </div>

      <div class="mb-2">
        <label for="last_name" class="form-label">Last Name</label>
        <input
          type="text"
          id="last_name"
          v-model="last_name"
          class="form-control"
          :class="{ 'is-invalid': v$['last_name'].$error }"
        />
        <span class="invalid-feedback" v-if="v$['last_name'].$error">
          {{ v$["last_name"].$errors[0].$message }}
        </span>
      </div>

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
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          id="password"
          v-model="password"
          class="form-control"
          :class="{ 'is-invalid': v$['password'].$error }"
        />
        <span class="invalid-feedback" v-if="v$['password'].$error">
          {{ v$["password"].$errors[0].$message }}
        </span>
      </div>

      <div class="mb-2">
        <button
          type="button"
          class="btn btn-success btn-lg w-100"
          @click="submitForm"
        >
          Register
        </button>
      </div>

      <div class="mb-2 text-center">
        <a href="/login" class="btn btn-link">I have an account</a>
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
    const first_name = ref();
    const last_name = ref();
    const email = ref();
    const password = ref();
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
      first_name,
      last_name,
      email,
      password,
      loading,
      v$,
      submitForm,
    };
  },

  validations: () => ({
    first_name: {
      required: helpers.withMessage("Required", required),
      max: helpers.withMessage("Too long", maxLength(50)),
    },
    last_name: {
      required: helpers.withMessage("Required", required),
      max: helpers.withMessage("Too long", maxLength(50)),
    },
    email: {
      required: helpers.withMessage("Required", required),
      max: helpers.withMessage("Too long", maxLength(50)),
    },
    password: {
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
