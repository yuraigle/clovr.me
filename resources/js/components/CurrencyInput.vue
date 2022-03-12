<template>
  <input ref="inputRef" type="text" />
</template>

<script>
import { useCurrencyInput } from "vue-currency-input";

export default {
  setup() {
    const { inputRef } = useCurrencyInput({
      currency: "EUR",
      precision: 2,
    });

    return { inputRef };
  },
};
</script>
