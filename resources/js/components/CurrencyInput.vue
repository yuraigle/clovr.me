<template>
    <input ref="inputRef" type="text" />
</template>

<script>
import { useCurrencyInput } from "vue-currency-input";

export default {
    setup() {
        const { inputRef } = useCurrencyInput({
            currency: "USD",
            precision: 2,
        });

        return { inputRef };
    },
};
</script>
