<template>
  <div class="card shadow-sm bg-light mt-4 mb-4 p-4">
    <a href="/auth/fb-redirect" class="btn btn-primary btn-lg w-100 bg-gradient">
      <i class="fa-brands fa-facebook-square me-1"></i>
      Sign in with Facebook
    </a>

    <div class="text-center text-muted mt-4 mb-1 lined_or">
      <p><span class="bg-light">or</span></p>
    </div>

    <form method="post">
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
        <a href="/forgot" class="float-end">Forgot your password?</a>
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
          class="btn btn-success btn-lg w-100 bg-gradient"
          :class="{ disabled: loading }"
          @click="submitForm"
        >
          Login
        </button>
      </div>

      <div class="mb-2 text-center">
        <a href="/register" class="btn btn-link">I'm new here </a>
      </div>
    </form>
  </div>
</template>

<script>
import {reactive, ref} from "vue";
import useVuelidate from "@vuelidate/core";
import {email, helpers, maxLength, minLength, required,} from "@vuelidate/validators";

export default {
  setup() {
    const form = reactive({
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
            "/login",
            {
              method: "POST",
              headers: {"X-CSRF-TOKEN": csrf()},
              body: formData,
            },
            () => {
              const urlParams = new URLSearchParams(window.location.search);
              window.location.href = urlParams.get("back") || "/";
            },
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

.lined_or > p {
  height: 1px;
  background: #ddd;
  margin-top: 10px;
}

.lined_or > p > span {
  padding: 10px;
  position: relative;
  top: -13px;
}
</style>
