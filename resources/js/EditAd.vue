<template>
  <form>
    <AdCategoryBox
      v-model:category_id="category_id"
      :errors="v$.category_id"
      :editable="false"
    />

    <AdTitleBox
      v-model:title="titleBox.title"
      v-model:bold="titleBox.bold"
      :errors="v$['titleBox']"
    />

    <AdDetailsBox
      :category="category_id"
      v-model:price="details.price"
      v-model:price_freq="details.price_freq"
      v-model:property_type="details.property_type"
      v-model:num_beds="details.num_beds"
      v-model:room_type="details.room_type"
      v-model:description="details.description"
      :errors="v$['details']"
    />
    <button type="button" @click="handleSubmit">OK</button>
  </form>
</template>

<script>
import { reactive, ref, onMounted } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required, helpers } from "@vuelidate/validators";
import AdCategoryBox from "./components/AdCategoryBox.vue";
import AdTitleBox from "./components/AdTitleBox.vue";
import AdDetailsBox from "./components/AdDetailsBox.vue";

export default {
  components: { AdCategoryBox, AdTitleBox, AdDetailsBox },

  setup() {
    const category_id = ref(2);

    const titleBox = reactive({
      title: undefined,
      bold: undefined,
    });

    const details = reactive({
      price: undefined,
      price_freq: undefined,
      property_type: undefined,
      num_beds: undefined,
      room_type: undefined,
      description: undefined,
    });

    const v$ = useVuelidate();

    function handleSubmit() {
      console.log(details);
      this.v$.$validate().then((res) => {
        console.log(res);
      });
    }

    onMounted(() => {
      const mdata = document.querySelector('meta[name="form-data"]').content;
      const fdata = JSON.parse(mdata);

      category_id.value = fdata.category_id;
      titleBox.title = fdata.title;
      details.price = fdata.price;
      details.price_freq = fdata.price_freq;
      details.property_type = fdata.property_type;
      details.num_beds = fdata.num_beds;
      details.room_type = fdata.room_type;
      details.description = fdata.description;
    });

    return {
      category_id,
      titleBox,
      details,
      v$,
      handleSubmit,
    };
  },

  validations: {
    category_id: {
      required: helpers.withMessage("Required", required),
    },
    titleBox: {
      title: {
        required: helpers.withMessage("Required", required),
        max: helpers.withMessage("Too long", maxLength(5)),
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
      },
    },
  },
};
</script>
