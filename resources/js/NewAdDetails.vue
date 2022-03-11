<template>
  <form method="post" class="row">
    <div class="col-xs-12 mb-4">
      <label for="category_id" class="form-label">Category</label>
      <select
        id="category_id"
        v-model="category_id"
        class="form-control"
        :class="{ 'is-invalid': v$['category_id'].$error }"
      >
        <option value="">Please select...</option>
        <option value="1">Property For Sale</option>
        <option value="2">Property To Rent</option>
        <option value="3">Property To Share</option>
        <option value="4">Parking &amp; Garage For Sale</option>
        <option value="5">Parking &amp; Garage To Rent</option>
      </select>
      <span class="invalid-feedback" v-if="v$['category_id'].$error">
        {{ v$["category_id"].$errors[0].$message }}
      </span>
    </div>

    <div class="col-xs-12 mb-4">
      <label for="title" class="form-label">Ad Title</label>
      <input
        type="text"
        id="title"
        v-model="title"
        class="form-control"
        :class="{ 'is-invalid': v$['title'].$error }"
      />
      <span class="invalid-feedback" v-if="v$['title'].$error">
        {{ v$["title"].$errors[0].$message }}
      </span>
    </div>

    <div class="col-sm-6 mb-2">
      <label for="price" class="form-label">Price:</label>
      <CurrencyInput
        id="price"
        v-model="price"
        class="form-control"
        :class="{ 'is-invalid': v$['price'].$error }"
      />
      <span class="invalid-feedback" v-if="v$['price'].$error">
        {{ v$["price"].$errors[0].$message }}
      </span>
    </div>

    <div class="col-sm-6 mb-2">
      <label for="property_type" class="form-label">Property Type:</label>
      <select
        id="property_type"
        v-model="property_type"
        class="form-control"
        :class="{ 'is-invalid': v$['property_type'].$error }"
      >
        <option value="">Please select...</option>
        <option value="flat">Flat</option>
        <option value="house">House</option>
        <option value="other">Other</option>
      </select>
      <span class="invalid-feedback" v-if="v$['property_type'].$error">
        {{ v$["property_type"].$errors[0].$message }}
      </span>
    </div>

    <div class="col-sm-6 mb-4">
      <label for="num_beds" class="form-label">No. of Bedrooms:</label>
      <select
        id="num_beds"
        v-model="num_beds"
        class="form-control"
        :class="{ 'is-invalid': v$['num_beds'].$error }"
      >
        <option value="">Please select...</option>
        <option value="0">Studio</option>
        <option v-for="index in 10" :key="index" :value="index">
          {{ index }}
        </option>
      </select>
      <span class="invalid-feedback" v-if="v$['num_beds'].$error">
        {{ v$["num_beds"].$errors[0].$message }}
      </span>
    </div>

    <label for="description" class="form-label">Description:</label>

    <div class="col-lg-9 col-md-8">
      <textarea
        id="description"
        v-model="description"
        class="form-control"
        :class="{ 'is-invalid': v$['description'].$error }"
        rows="6"
      ></textarea>
      <span class="invalid-feedback" v-if="v$['description'].$error">
        {{ v$["description"].$errors[0].$message }}
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
import { ref } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required, helpers } from "@vuelidate/validators";
import CurrencyInput from "./components/CurrencyInput.vue";

export default {
  components: {
    CurrencyInput,
  },

  setup() {
    const category_id = ref("");
    const title = ref();
    const price = ref();
    const property_type = ref("");
    const num_beds = ref("");
    const description = ref();
    const loading = ref(false);
    const v$ = useVuelidate();

    function submitForm() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;

          const postData = {
            category_id: this.category_id,
            title: this.title,
            price: this.price,
            property_type: this.property_type,
            num_beds: this.num_beds,
            description: this.num_beds,
          };

          const csrf = document.querySelector(
            'meta[name="csrf-token"]'
          ).content;
          const formData = new FormData();
          for (let key in postData) {
            formData.append(key, postData[key]);
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
      category_id,
      title,
      price,
      property_type,
      num_beds,
      description,
      loading,
      v$,
      submitForm,
    };
  },

  validations: () => ({
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
  }),
};
</script>
