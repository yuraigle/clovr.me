<template>
  <form class="row">
    <AdCategoryBox
      v-model:category_id="ad.category_id"
      :editable="true"
      :errors="v$['ad']"
    />

    <AdTitleBox
      v-model:title="ad.title"
      v-model:bold="ad.bold"
      :errors="v$['ad']"
    />

    <AdLocationBox v-model:address="address" :errors="v$['address']" />

    <AdDetailsBox
      :category="ad.category_id"
      v-model:details="details"
      :errors="v$['details']"
    />

    <AdImagesBox
      v-model:pictures="pictures"
      v-model:youtube="ad.youtube"
      :errors="v$['ad']"
    />

    <AdWebsiteBox
      v-model:has_www="ad.has_www"
      v-model:www="ad.www"
      :errors="v$['ad']"
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
    const ad = reactive({
      id: null,
      category_id: null,
      title: null,
      is_bold: false,
      has_www: false,
      www: null,
      youtube: null,
    });

    const details = reactive({
      price: null,
      property_type: null,
      num_beds: null,
      price_freq: null,
      room_type: null,
      description: null,
    });

    const address = reactive({
      postcode: null,
      county: null,
      town: null,
      location: null,
      lng: null,
      lat: null,
    });

    const pictures = ref([]);
    const loading = ref(false);
    const v$ = useVuelidate();

    function handleSubmit() {
      this.v$.$validate().then((res) => {
        if (res) {
          loading.value = true;

          const postData = Object.assign({}, ad, details, address);
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
      ad,
      details,
      address,
      pictures,
      loading,
      v$,
      handleSubmit,
    };
  },

  validations: {
    ad: {
      category_id: {
        required: helpers.withMessage("Required", required),
      },
      title: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(100)),
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
    details: {
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
