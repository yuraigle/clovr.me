<template>
  <form class="row">
    <AdCategoryBox
      v-model:category_id="ad.category_id"
      :editable="false"
      :errors="v$['ad']"
    />

    <AdTitleBox v-model:title="ad.title" v-model:bold="ad.bold" :errors="v$['ad']" />

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

    <AdWebsiteBox v-model:has_www="ad.has_www" v-model:www="ad.www" :errors="v$['ad']" />

    <div class="w-100 mt-2 mb-2 text-end">
      <button
        type="button"
        class="btn btn-primary bg-gradient"
        :class="{ disabled: loading }"
        @click="handleSubmit"
      >
        Save
        <i class="fa-solid fa-spinner" v-if="loading"></i>
        <i class="fa-solid fa-chevron-right" v-else></i>
      </button>
    </div>
  </form>
</template>

<script>
import { reactive, ref, onMounted } from "vue";
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
      id: undefined,
      category_id: undefined,
      title: undefined,
      is_bold: false,
      has_www: false,
      www: undefined,
      youtube: undefined,
    });

    const details = reactive({
      price: null,
      property_type: undefined,
      num_beds: undefined,
      price_freq: undefined,
      room_type: undefined,
      description: undefined,
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
            "/edit-ad/" + ad.id,
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

    onMounted(() => {
      const mdata = document.querySelector('meta[name="form-data"]').content;
      const fdata = JSON.parse(mdata);

      ad.id = fdata.id;
      ad.category_id = fdata.category_id;
      ad.title = fdata.title;
      ad.youtube = fdata.youtube;
      ad.www = fdata.www;

      details.price = fdata.price;
      details.property_type = fdata.property_type;
      details.num_beds = fdata.num_beds;
      details.price_freq = fdata.price_freq;
      details.room_type = fdata.room_type;
      details.description = fdata.description;

      address.location = fdata.location;
      address.postcode = fdata.postcode;
      address.county = fdata.county;
      address.town = fdata.town;
      address.lng = fdata.lng;
      address.lat = fdata.lat;

      fdata.pictures.forEach((el) => {
        pictures.value.push(el.name);
      });
    });

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
