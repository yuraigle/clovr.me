<template>
  <form class="row">
    <AdCategoryBox
      v-model:category_id="ad.category_id"
      :editable="true"
      :errors="v$.ad"
    />

    <AdTitleBox
      v-model:title="ad.title"
      v-model:bold="ad.bold"
      :errors="v$.ad"
    />

    <AdLocationBox
      mode="input"
      v-model:address="address"
      :errors="v$.address"
      @validate="v$.address.$validate()"
    />

    <AdDetailsBox
      :category="ad.category_id"
      v-model:details="details"
      :errors="v$.details"
    />

    <AdImagesBox
      v-model:pictures="pictures"
      v-model:youtube="ad.youtube"
      :errors="v$.ad"
    />

    <AdWebsiteBox
      v-model:has_www="ad.has_www"
      v-model:www="ad.www"
      :errors="v$.ad"
    />

    <div class="w-100 mt-2 mb-2 text-end">
      <button
        type="button"
        class="btn btn-primary bg-gradient"
        :class="{ disabled: loading }"
        @click="handleSubmit"
      >
        Next
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="24"
             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
             stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <polyline points="9 6 15 12 9 18"/>
        </svg>
      </button>
    </div>
  </form>
</template>

<script>
import {reactive, ref} from "vue";
import useVuelidate from "@vuelidate/core";
import {helpers, maxLength, minLength, required, url} from "@vuelidate/validators";
import AdCategoryBox from "./AdCategoryBox.vue";
import AdTitleBox from "./AdTitleBox.vue";
import AdDetailsBox from "./AdDetailsBox.vue";
import AdWebsiteBox from "./AdWebsiteBox.vue";
import AdImagesBox from "./AdImagesBox.vue";
import AdLocationBox from "./AdLocationBox.vue";

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
      location: null,
      town: null,
      county: null,
      postcode: null,
      lng: null,
      lat: null,
    });

    const pictures = ref([]);
    const loading = ref(false);
    const v$ = useVuelidate();

    function handleSubmit() {
      this.v$.$validate().then((valid) => {
        if (!valid) {
          showToast("Correct highlighted errors and try again.");
          return;
        }

        const body = new FormData();
        const postData = Object.assign({}, ad, details, address);
        for (const key in postData) {
          if (postData[key] !== undefined && postData[key] !== null) {
            body.append(key, postData[key]);
          }
        }
        for (const pic of pictures.value) {
          body.append("pictures[]", pic);
        }

        loading.value = true;
        fetchApi({
            url: "/new",
            opts: {method: "POST", headers: {"X-CSRF-TOKEN": csrf()}, body},
            _success: (resp) => (window.location.href = "/activate?id=" + resp.id),
            _finally: () => (loading.value = false)
          }
        );
      });
    }

    return {
      v$,
      ad,
      details,
      address,
      pictures,
      loading,
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
        required: helpers.withMessage("Required", required),
        min: helpers.withMessage("Too short", minLength(5)),
        max: helpers.withMessage("Too long", maxLength(250)),
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
