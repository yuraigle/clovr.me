<template>
  <div class="card shadow-sm bg-light mt-4 mb-4 p-4">
    <button type="button" class="btn btn-primary btn-lg w-100">
      <i class="fa-brands fa-facebook-square me-1"></i>
      Sign in with Facebook
    </button>

    <p class="text-center text-muted mt-3 mb-3">or</p>

    <form method="post">
      <div class="w-100" v-if="be_messages.length">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            @click="be_messages.length = 0"
          ></button>
          <strong>Warning</strong>
          <ul class="mb-0">
            <li v-for="msg in be_messages" :key="msg">{{ msg }}</li>
          </ul>
        </div>
      </div>

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
import { maxLength, minLength, required, helpers } from "@vuelidate/validators";

export default {
  setup() {
    const form = reactive({
      name: undefined,
      email: undefined,
      password: undefined,
    });

    const loading = ref(false);
    const be_messages = ref([]);
    const v$ = useVuelidate();

    function csrf() {
      return document.querySelector('meta[name="csrf-token"]').content;
    }

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

          fetch("/register", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrf() },
            body: formData,
          })
            .then((resp) => resp.json())
            .then((result) => {
              be_messages.value.length = 0;
              if (result.access_token && result.token_type === "Bearer") {
                window.location.href = "/";
              } else if (result.status === "FAIL") {
                for (const key in result.messages) {
                  be_messages.value.push(result.messages[key][0]);
                }
              } else {
                be_messages.value.push("Something went wrong");
              }
            })
            .catch((error) => console.error("Error:", error))
            .finally(() => (loading.value = false));
        }
      });
    }

    return {
      form,
      loading,
      be_messages,
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
