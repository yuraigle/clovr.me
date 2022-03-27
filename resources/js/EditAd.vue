<template>
  <form>
    <AdTitleBox
      v-model:title="titleBox.title"
      v-model:bold="titleBox.bold"
      :errors="v$['titleBox']"
    />

    <AdDetailsBox
      :category="2"
      v-model:price="details.price"
      v-model:price_freq="details.price_freq"
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
import AdTitleBox from "./components/AdTitleBox.vue";
import AdDetailsBox from "./components/AdDetailsBox.vue";

export default {
  components: { AdTitleBox, AdDetailsBox },

  setup() {
    const titleBox = reactive({
      title: "Titl",
      bold: true,
    });

    const details = reactive({
      price: 125.99,
      price_freq: undefined,
      description: "Wow Great!",
    });

    const v$ = useVuelidate();

    function handleSubmit() {
      console.log(details);
      this.v$.$validate().then((res) => {
        console.log(res);
      });
    }

    return {
      titleBox,
      details,
      v$,
      handleSubmit,
    };
  },

  validations: {
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
      description: {
        required: helpers.withMessage("Required", required),
      },
    },
  },
};
</script>
