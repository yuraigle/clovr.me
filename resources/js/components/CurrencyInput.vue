<template>
  <input ref="inputRef" />
</template>

<script>
import { watch } from "vue";
import { useCurrencyInput } from "vue-currency-input";

export default {
  props: ["modelValue"],

  setup(props) {
    const { inputRef, setValue } = useCurrencyInput({
      currency: "EUR",
      precision: 2,
    });

    watch(
      () => props.modelValue,
      (val) => {
        setValue(val);
      }
    );

    return { inputRef };
  },
};
</script>
