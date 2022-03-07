<template>
    <div class="d-flex flex-row w-100">
        <div>
            <input
                type="text"
                v-model="postcode"
                class="form-control"
                :class="{ 'is-invalid': v$['postcode'].$error }"
                placeholder="ZipCode"
                style="width: 100px"
            />
            <span class="invalid-feedback" v-if="v$['postcode'].$error">
                {{ v$["postcode"].$errors[0].$message }}
            </span>
        </div>
        <div class="ms-1">
            <input
                type="text"
                v-model="town"
                class="form-control"
                :class="{ 'is-invalid': v$['town'].$error }"
                placeholder="Town"
            />
            <span class="invalid-feedback" v-if="v$['town'].$error">
                {{ v$["town"].$errors[0].$message }}
            </span>
        </div>
        <div class="flex-grow-1 ms-1">
            <input
                type="text"
                v-model="street"
                class="form-control"
                :class="{ 'is-invalid': v$['street'].$error }"
                placeholder="Street"
            />
            <span class="invalid-feedback" v-if="v$['street'].$error">
                {{ v$["street"].$errors[0].$message }}
            </span>
        </div>
        <div class="ms-1">
            <input
                type="text"
                v-model="unit"
                class="form-control"
                :class="{ 'is-invalid': v$['unit'].$error }"
                placeholder="Unit#"
                style="width: 100px"
            />
            <span class="invalid-feedback" v-if="v$['unit'].$error">
                {{ v$["unit"].$errors[0].$message }}
            </span>
        </div>
        <div class="ms-1">
            <button
                class="btn btn-outline-secondary"
                type="button"
                @click="submitSearch"
            >
                <i class="fa-solid fa-location-arrow"></i>
            </button>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required } from "@vuelidate/validators";

export default {
    setup() {
        const postcode = ref("");
        const town = ref("");
        const street = ref("");
        const unit = ref("");
        const v$ = useVuelidate();

        function submitSearch() {
            this.v$.$validate().then((res) => {
                if (res) {
                    window.showOnMap({
                        postcode: postcode.value,
                        town: town.value,
                        street: street.value,
                        unit: unit.value,
                    });
                }
            });
        }

        return {
            postcode,
            town,
            street,
            unit,
            v$,
            submitSearch,
        };
    },

    validations: () => ({
        postcode: {
            max: maxLength(3),
        },

        town: {
            // required,
            max: maxLength(20),
        },

        street: {
            // required,
            max: maxLength(50),
        },

        unit: {
            max: maxLength(5),
        },
    }),
};
</script>
