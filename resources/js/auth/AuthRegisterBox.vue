<template>
  <div class="card shadow-sm mt-4 mb-4 p-4">
    <a href="/auth/fb-redirect" class="btn btn-primary btn-lg w-100 bg-gradient bg-fb">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook" width="24" height="24"
           viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
           stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"/>
      </svg>
      Sign in with Facebook
    </a>

    <div class="text-center text-muted mt-4 mb-1 lined_or">
      <p><span class="bg-white px-4">or</span></p>
    </div>

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
          class="btn btn-success btn-lg w-100 bg-gradient"
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
import {reactive, ref} from "vue";
import useVuelidate from "@vuelidate/core";
import {email, helpers, maxLength, minLength, required,} from "@vuelidate/validators";
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

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
      this.v$.$validate().then((valid) => {
        if (!valid) return;

        const body = new FormData();
        for (const key in form) {
          if (form[key] !== undefined) {
            body.append(key, form[key]);
          }
        }

        loading.value = true;
        axios.post('/register', body)
          .then(res => {
            if (res.status === 200) {
              const urlParams = new URLSearchParams(window.location.search);
              window.location.href = urlParams.get("back") || "/";
            }
          })
          .catch((err) => showError(err))
          .finally(() => loading.value = false);

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
