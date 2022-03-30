<template>
  <form class="row">
    <AdCategoryBox
      v-model:category_id="details.category_id"
      :editable="true"
      :errors="v$['details']"
    />

    <AdTitleBox
      v-model:title="details.title"
      v-model:bold="details.bold"
      :errors="v$['details']"
    />

    <AdLocationBox v-model:address="address" :errors="v$['address']" />

    <AdDetailsBox
      :category="details.category_id"
      v-model:price="details.price"
      v-model:price_freq="details.price_freq"
      v-model:property_type="details.property_type"
      v-model:num_beds="details.num_beds"
      v-model:room_type="details.room_type"
      v-model:description="details.description"
      :errors="v$['details']"
    />

    <AdImagesBox
      v-model:pictures="pictures"
      v-model:youtube="details.youtube"
      :errors="v$['details']"
    />

    <AdWebsiteBox
      v-model:has_www="details.has_www"
      v-model:www="details.www"
      :errors="v$['details']"
    />

    <div class="w-100 mt-2 mb-2 text-end">
      <button
        type="button"
        class="btn btn-primary bg-gradient"
        :class="{ disabled: loading }"
        @click="handleSubmit"
      >
        Next
        <i class="fa-solid fa-spinner" v-if="loading"></i>
        <i class="fa-solid fa-chevron-right" v-else></i>
      </button>
    </div>
  </form>
</template>

<script>
import { reactive, ref } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required, helpers, url } from "@vuelidate/validators";
import AdCategoryBox from "./components/AdCategoryBox.vue";
import AdTitleBox from "./components/AdTitleBox.vue";
import AdDetailsBox from "./components/AdDetailsBox.vue";
import AdWebsiteBox from "./components/AdWebsiteBox.vue";
import AdImagesBox from "./components/AdImagesBox.vue";
import AdLocationBox from "./components/AdLocationBox.vue";

export default {
  components: {
    AdCategoryBox,
    AdTitleBox,
    AdDetailsBox,
    AdWebsiteBox,
    AdImagesBox,
    AdLocationBox,
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
      www: undefined,
      youtube: undefined,
      has_www: false,
      is_bold: false,
    });

    const address = reactive({
      postcode: undefined,
      county: undefined,
      town: undefined,
      location: undefined,
      lng: undefined,
      lat: undefined,
    });

    const pictures = ref([]);
    const loading = ref(false);
    const v$ = useVuelidate();

    function handleSubmit() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;

          const postData = Object.assign({}, details, address);
          const formData = new FormData();
          for (const key in postData) {
            if (postData[key] !== undefined && postData[key] !== null) {
              formData.append(key, postData[key]);
            }
          }
          for (const pic of pictures.value) {
            formData.append("pictures[]", pic);
          }

          fetchApi(
            "/new-ad",
            {
              method: "POST",
              headers: { "X-CSRF-TOKEN": csrf() },
              body: formData,
            },
            (resp) => (window.location.href = "/activate?id=" + resp.id),
            () => (loading.value = false)
          );
        }
      });
    }

    return {
      details,
      address,
      pictures,
      loading,
      v$,
      handleSubmit,
    };
  },

  validations: {
    details: {
      category_id: {
        required: helpers.withMessage("Required", required),
      },
      title: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(5)),
      },
      price: {
        required: helpers.withMessage("Required", required),
      },
      price_freq: {},
      property_type: {},
      num_beds: {},
      room_type: {},
      description: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(10000)),
      },
      www: {
        url,
        max: helpers.withMessage("Too long", maxLength(500)),
      },
      youtube: {
        url,
        yt2: helpers.withMessage(
          "Not a valid YouTube link",
          helpers.regex(/^https?:\/\/(www\.)?youtube\.com\/watch/)
        ),
        max: maxLength(100),
      },
    },
    address: {
      location: {
        required,
      },
    },
  },
};
</script>

<style scoped>
form {
  max-width: 900px;
  margin: 0 auto;
}
</style>
