<template>
    <div class="d-flex flex-row w-100">
        <div>
            <input
                id="_postcode"
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
                id="_county"
                type="text"
                v-model="county"
                class="form-control"
                :class="{ 'is-invalid': v$['county'].$error }"
                placeholder="County"
            />
            <span class="invalid-feedback" v-if="v$['county'].$error">
                {{ v$["county"].$errors[0].$message }}
            </span>
        </div>

        <div class="ms-1">
            <input
                id="_town"
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
                id="_address"
                type="text"
                v-model="address"
                class="form-control"
                :class="{ 'is-invalid': v$['address'].$error }"
                placeholder="Address"
            />
            <span class="invalid-feedback" v-if="v$['address'].$error">
                {{ v$["address"].$errors[0].$message }}
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
        const county = ref("");
        const town = ref("");
        const address = ref("");
        const v$ = useVuelidate();

        function submitSearch() {
            this.v$.$validate().then((res) => {
                if (res) {
                    window.showOnMap({
                        postcode: postcode.value,
                        county: county.value,
                        town: town.value,
                        address: address.value,
                    });
                }
            });
        }

        return {
            postcode,
            county,
            town,
            address,
            v$,
            submitSearch,
        };
    },

    validations: () => ({
        postcode: {
            max: maxLength(3),
        },

        county: {
            max: maxLength(20),
        },

        town: {
            // required,
            max: maxLength(20),
        },

        address: {
            // required,
            max: maxLength(50),
        },
    }),
};
</script>
