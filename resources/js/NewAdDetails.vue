<template>
  <form method="post" class="row">
    <div class="col-xs-12 mb-4">
      <label for="category_id" class="form-label">Category</label>
      <select
        id="category_id"
        v-model="details.category_id"
        class="form-control"
        :class="{ 'is-invalid': v$['details'].category_id.$error }"
      >
        <option value="">Please select...</option>
        <option value="1">Property For Sale</option>
        <option value="2">Property To Rent</option>
        <option value="3">Property To Share</option>
        <option value="4">Parking &amp; Garage For Sale</option>
        <option value="5">Parking &amp; Garage To Rent</option>
      </select>
      <span class="invalid-feedback" v-if="v$['details'].category_id.$error">
        {{ v$["details"].category_id.$errors[0].$message }}
      </span>
    </div>

    <div class="col-xs-12 mb-4">
      <label for="title" class="form-label">Ad Title</label>
      <input
        type="text"
        id="title"
        v-model="details.title"
        class="form-control"
        :class="{ 'is-invalid': v$['details'].title.$error }"
      />
      <span class="invalid-feedback" v-if="v$['details'].title.$error">
        {{ v$["details"].title.$errors[0].$message }}
      </span>
    </div>

    <div class="col-sm-6 mb-2">
      <label
        for="price"
        class="form-label"
        v-if="['2', '3', '5'].includes(details.category_id)"
      >
        Rent:
      </label>
      <label for="price" class="form-label" v-else>Price:</label>
      <CurrencyInput
        id="price"
        v-model="details.price"
        class="form-control"
        :class="{ 'is-invalid': v$['details'].price.$error }"
      />
      <span class="invalid-feedback" v-if="v$['details'].price.$error">
        {{ v$["details"].price.$errors[0].$message }}
      </span>
    </div>

    <div
      class="col-sm-6 mb-2"
      v-if="['2', '3', '5'].includes(details.category_id)"
    >
      <label for="price_freq" class="form-label">Rent period:</label>

      <div
        class="form-check"
        :class="{ 'is-invalid': v$['details'].price_freq.$error }"
      >
        <input
          type="radio"
          id="price_freq_m"
          name="price_freq"
          v-model="details.price_freq"
          class="form-check-input float-none me-1"
          :class="{ 'is-invalid': v$['details'].price_freq.$error }"
          value="per_month"
        />
        <label class="form-check-label me-4 ps-1 pe-2" for="price_freq_m">
          Monthly
        </label>

        <input
          type="radio"
          id="price_freq_w"
          name="price_freq"
          v-model="details.price_freq"
          class="form-check-input float-none ms-2 me-1"
          :class="{ 'is-invalid': v$['details'].price_freq.$error }"
          value="per_week"
        />
        <label class="form-check-label me-4 ps-1 pe-2" for="price_freq_w">
          Weekly
        </label>
      </div>

      <span class="invalid-feedback" v-if="v$['details'].price_freq.$error">
        {{ v$["details"].price_freq.$errors[0].$message }}
      </span>
    </div>

    <div class="col-sm-6 mb-2" v-if="details.category_id > 0">
      <label for="property_type" class="form-label">Property Type:</label>
      <select
        id="property_type"
        v-model="details.property_type"
        class="form-control"
        :class="{ 'is-invalid': v$['details'].property_type.$error }"
      >
        <option value="">Please select...</option>
        <option value="flat" v-if="details.category_id < 4">Flat</option>
        <option value="house" v-if="details.category_id < 4">House</option>
        <option value="other" v-if="details.category_id < 4">Other</option>
        <option value="garage" v-if="details.category_id >= 4">Garage</option>
        <option value="parking" v-if="details.category_id >= 4">
          Parking space
        </option>
      </select>
      <span class="invalid-feedback" v-if="v$['details'].property_type.$error">
        {{ v$["details"].property_type.$errors[0].$message }}
      </span>
    </div>

    <div class="col-sm-6 mb-4" v-if="['1', '2'].includes(details.category_id)">
      <label for="num_beds" class="form-label">No. of Bedrooms:</label>
      <select
        id="num_beds"
        v-model="details.num_beds"
        class="form-control"
        :class="{ 'is-invalid': v$['details'].num_beds.$error }"
      >
        <option value="">Please select...</option>
        <option value="0">Studio</option>
        <option v-for="index in 10" :key="index" :value="index">
          {{ index }}
        </option>
      </select>
      <span class="invalid-feedback" v-if="v$['details'].num_beds.$error">
        {{ v$["details"].num_beds.$errors[0].$message }}
      </span>
    </div>

    <div class="col-sm-6 mb-2" v-if="['3'].includes(details.category_id)">
      <label for="room_type" class="form-label">Room type:</label>
      <select
        id="room_type"
        v-model="details.room_type"
        class="form-control"
        :class="{ 'is-invalid': v$['details'].room_type.$error }"
      >
        <option value="">Please select...</option>
        <option value="single">Single room</option>
        <option value="double">Double room</option>
        <option value="twin">Twin room</option>
        <option value="triple">Triple room</option>
        <option value="shared">Shared room</option>
        <option value="couch">Couch Surf</option>
      </select>
      <span class="invalid-feedback" v-if="v$['details'].room_type.$error">
        {{ v$["details"].room_type.$errors[0].$message }}
      </span>
    </div>

    <label for="description" class="form-label">Description:</label>

    <div class="col-lg-9 col-md-8">
      <textarea
        id="description"
        v-model="details.description"
        class="form-control"
        :class="{ 'is-invalid': v$['details'].description.$error }"
        rows="6"
      ></textarea>
      <span class="invalid-feedback" v-if="v$['details'].description.$error">
        {{ v$["details"].description.$errors[0].$message }}
      </span>
    </div>

    <div class="col-lg-3 col-md-4 lh-sm">
      <small class="text-muted">
        Enter as much information possible; Ads with detailed and longer
        descriptions get more views and replies!
      </small>
    </div>

    <div class="w-100">&nbsp;</div>

    <div class="w-100 mt-2 mb-2 text-end">
      <button
        type="button"
        class="btn btn-primary"
        :class="{ disabled: loading }"
        @click="submitForm"
        style="width: 80px"
      >
        Next
        <i class="fa-solid fa-spinner" v-if="loading"></i>
        <i class="fa-solid fa-chevron-right" v-else></i>
      </button>
    </div>
  </form>
</template>

<script>
import { reactive, ref, onMounted } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required, helpers } from "@vuelidate/validators";
import CurrencyInput from "./components/CurrencyInput.vue";

export default {
  components: {
    CurrencyInput,
  },

  setup() {
    const details = reactive({
      category_id: undefined,
      title: undefined,
      price: undefined,
      property_type: undefined,
      num_beds: undefined,
      description: undefined,
      price_freq: undefined,
      room_type: undefined,
    });

    const loading = ref(false);
    const v$ = useVuelidate();

    onMounted(() => {
      const draft = localStorage.getItem("frm1");
      if (draft) {
        const frm0 = JSON.parse(draft);
        Object.assign(details, frm0); // todo: price??
      }
    });

    function submitForm() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;

          localStorage.setItem("frm1", JSON.stringify(this.details));

          const csrf = document.querySelector(
            'meta[name="csrf-token"]'
          ).content;
          const formData = new FormData();
          for (let key in this.details) {
            formData.append(key, this.details[key]);
          }

          fetch("/new-ad", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrf },
            body: formData,
          })
            .then((response) => response.json())
            .then((result) => {
              window.location.href = "/new-ad-location";
            })
            .catch((error) => console.error("Error:", error))
            .finally(() => (loading.value = false));
        }
      });
    }

    return {
      details,
      loading,
      v$,
      submitForm,
    };
  },

  validations: {
    details: {
      category_id: {
        required: helpers.withMessage("Required", required),
      },
      title: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(100)),
      },
      price: {
        required: helpers.withMessage("Required", required),
      },
      property_type: {},
      num_beds: {},
      description: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(10000)),
      },
      price_freq: {}, // todo: requiredIf
      room_type: {},
    },
  },
};
</script>

<style scoped>
form {
  max-width: 850px;
  margin: 0 auto;
}
.form-check {
  padding-top: 0.375rem;
  padding-bottom: 0.375rem;
  border: 1px solid transparent;
}
</style>
