<template>
  <div class="card shadow-sm bg-light mt-4 mb-4 p-4">
    <button type="button" class="btn btn-primary btn-lg w-100">
      <i class="fa-brands fa-facebook-square me-1"></i>
      Sign in with Facebook
    </button>

    <p class="text-center text-muted mt-3 mb-3">or</p>

    <form method="post">
      <div class="mb-2">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          id="name"
          v-model="form.name"
          class="form-control"
          :class="{ 'is-invalid': v$['form'].name.$error }"
        />
        <span class="invalid-feedback" v-if="v$['form'].name.$error">
          {{ v$["form"].name.$errors[0].$message }}
        </span>
      </div>

      <div class="mb-2">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          class="form-control"
          :class="{ 'is-invalid': v$['form'].email.$error }"
        />
        <span class="invalid-feedback" v-if="v$['form'].email.$error">
          {{ v$["form"].email.$errors[0].$message }}
        </span>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          id="password"
          v-model="form.password"
          class="form-control"
          :class="{ 'is-invalid': v$['form'].password.$error }"
        />
        <span class="invalid-feedback" v-if="v$['form'].password.$error">
          {{ v$["form"].password.$errors[0].$message }}
        </span>
      </div>

      <div class="mb-2">
        <button
          type="button"
          class="btn btn-success btn-lg w-100"
          :class="{ disabled: loading }"
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
import { ref, reactive } from "vue";
import useVuelidate from "@vuelidate/core";
import {
  email,
  maxLength,
  minLength,
  required,
  helpers,
} from "@vuelidate/validators";

export default {
  setup() {
    const form = reactive({
      name: undefined,
      email: undefined,
      password: undefined,
    });

    const loading = ref(false);
    const v$ = useVuelidate();

    function submitForm() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;

          const formData = new FormData();
          for (const key in form) {
            if (form[key] !== undefined) {
              formData.append(key, form[key]);
            }
          }

          fetchApi(
            "/register",
            {
              method: "POST",
              headers: { "X-CSRF-TOKEN": csrf() },
              body: formData,
            },
            () => (window.location.href = "/"),
            () => (loading.value = false)
          );
        }
      });
    }

    return {
      form,
      loading,
      v$,
      submitForm,
    };
  },

  validations: () => ({
    form: {
      name: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(50)),
      },
      email: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(50)),
        email,
      },
      password: {
        min: minLength(6),
        max: helpers.withMessage("Too long", maxLength(50)),
        required: helpers.withMessage("Required", required),
      },
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
