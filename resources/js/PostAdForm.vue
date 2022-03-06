<template>
    <div class="row">
        <div class="col-xs-12 mb-4">
            <label for="category_id" class="form-label">Category</label>
            <select
                id="category_id"
                class="form-control"
                :class="{ 'is-invalid': v$.category_id.$error }"
                v-model="category_id"
                @change="v$.category_id.$touch"
            >
                <option value="">Please select...</option>
                <option value="1">Property For Sale</option>
                <option value="2">Property To Rent</option>
                <option value="3">Property To Share</option>
                <option value="4">Parking &amp; Garage For Sale</option>
                <option value="5">Parking &amp; Garage To Rent</option>
            </select>
            <span class="invalid-feedback" v-if="v$.category_id.$error">
                {{ v$.category_id.$errors[0].$message }}
            </span>
        </div>

        <div class="col-xs-12 mb-4">
            <label for="title" class="form-label">Ad Title</label>
            <input
                type="text"
                id="title"
                class="form-control"
                :class="{ 'is-invalid': v$.title.$error }"
                v-model="title"
                @blur="v$.title.$touch"
            />
            <span class="invalid-feedback" v-if="v$.title.$error">
                {{ v$.title.$errors[0].$message }}
            </span>
        </div>

        <div class="col-sm-6 mb-2">
            <label for="price" class="form-label">Price:</label>
            <CurrencyInput
                id="price"
                class="form-control"
                :class="{ 'is-invalid': v$.price.$error }"
                v-model="price"
                @blur="v$.price.$touch"
            />
            <span class="invalid-feedback" v-if="v$.price.$error">
                {{ v$.price.$errors[0].$message }}
            </span>
        </div>

        <div class="col-sm-6 mb-2">
            <label for="property_type" class="form-label">Property Type:</label>
            <select
                id="property_type"
                class="form-control"
                :class="{ 'is-invalid': v$.property_type.$error }"
                v-model="property_type"
                @change="v$.property_type.$touch"
            >
                <option value="">Please select...</option>
                <option value="flat">Flat</option>
                <option value="house">House</option>
                <option value="other">Other</option>
            </select>
            <span class="invalid-feedback" v-if="v$.property_type.$error">
                {{ v$.property_type.$errors[0].$message }}
            </span>
        </div>

        <div class="col-sm-6 mb-4">
            <label for="num_beds" class="form-label">No. of Bedrooms:</label>
            <select
                id="num_beds"
                class="form-control"
                :class="{ 'is-invalid': v$.num_beds.$error }"
                v-model="num_beds"
                @change="v$.num_beds.$touch"
            >
                <option value="">Please select...</option>
                <option value="0">Studio</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <span class="invalid-feedback" v-if="v$.num_beds.$error">
                {{ v$.num_beds.$errors[0].$message }}
            </span>
        </div>

        <div class="row mb-4">
            <label for="description" class="form-label w-100">
                Description
            </label>
            <div class="col-lg-9 col-md-8">
                <textarea
                    id="description"
                    class="form-control"
                    :class="{ 'is-invalid': v$.description.$error }"
                    v-model="description"
                    rows="6"
                    @blur="v$.description.$touch"
                ></textarea>
                <span class="invalid-feedback" v-if="v$.description.$error">
                    {{ v$.description.$errors[0].$message }}
                </span>
            </div>
            <div class="col-lg-3 col-md-4 lh-sm">
                <small class="text-muted">
                    Enter as much information possible; Ads with detailed and
                    longer descriptions get more views and replies!
                </small>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-auto">
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="submitForm"
                >
                    <i class="fa-solid fa-pen-to-square me-1"></i> Post My Ad
                </button>
            </div>
            <div class="col-auto lh-sm">
                <small class="text-muted">
                    By selecting Post My Ad you agree you've read and accepted
                    our <a href="/terms" target="_blank">Terms of Use</a>.
                </small>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import useVuelidate from "@vuelidate/core";
import { maxLength, required } from "@vuelidate/validators";
import CurrencyInput from "./components/CurrencyInput.vue";

export default {
    components: {
        CurrencyInput,
    },

    setup() {
        const category_id = ref();
        const title = ref();
        const price = ref();
        const property_type = ref();
        const num_beds = ref();
        const description = ref();
        const v$ = useVuelidate();

        function submitForm() {
            this.v$.$validate().then((res) => {
                if (res) {
                    const formData = {
                        category_id: this.category_id,
                        title: this.title,
                        price: this.price,
                        property_type: this.property_type,
                        num_beds: this.num_beds,
                        description: this.num_beds,
                    };

                    console.log(formData);
                } else {
                    console.log(this.v$);
                    return false;
                }
            });
        }

        return {
            category_id,
            title,
            price,
            property_type,
            num_beds,
            description,
            v$,
            submitForm,
        };
    },

    validations: () => ({
        category_id: {
            required,
        },
        title: {
            required,
            max: maxLength(10),
        },
        price: {
            required,
        },
        property_type: {
            required,
        },
        num_beds: {
            required,
        },
        description: {
            required,
            max: maxLength(10000),
        },
    }),
};
</script>
