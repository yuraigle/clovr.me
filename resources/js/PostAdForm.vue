<template>
    <div class="row">
        <div class="col-xs-12 mb-4">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id">
                <option>Please select...</option>
                <option value="1">Property For Sale</option>
                <option value="2">Property To Rent</option>
                <option value="3">Property To Share</option>
                <option value="4">Parking & Garage For Sale</option>
                <option value="5">Parking & Garage To Rent</option>
            </select>
        </div>

        <div class="col-xs-12 mb-4">
            <label for="title" class="form-label">Ad Title</label>
            <input type="text" class="form-control" id="title" v-model="title"
                   @blur="v$.title.$touch" :class="{'is-invalid': v$.title.$error}"/>
            <span class="invalid-feedback" v-if="v$.title.$error">
                    @{{ v$.title.$errors[0].$message }}
                </span>
        </div>

        <div class="col-sm-6 mb-2">
            <label for="price" class="form-label">Price:</label>
            <input type="text" class="form-control" id="price" v-model="price"
                   @blur="v$.price.$touch" :class="{'is-invalid': v$.price.$error}"/>
            <span class="invalid-feedback" v-if="v$.price.$error">
                    @{{ v$.price.$errors[0].$message }}
                </span>
        </div>

        <div class="col-sm-6 mb-2">
            <label for="property_type" class="form-label">Property Type:</label>
            <select class="form-control" id="property_type" v-model="property_type"
                    @change="v$.property_type.$touch" :class="{'is-invalid': v$.property_type.$error}">
                <option>Please select...</option>
                <option value="flat">Flat</option>
                <option value="house">House</option>
                <option value="other">Other</option>
            </select>
            <span class="invalid-feedback" v-if="v$.property_type.$error">
                    @{{ v$.property_type.$errors[0].$message }}
                </span>
        </div>

        <div class="col-sm-6 mb-4">
            <label for="num_beds" class="form-label">No. of Bedrooms:</label>
            <select class="form-control" id="num_beds" name="num_beds">
                <option>Please select...</option>
                <option value="0">Studio</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>

        <label for="description" class="form-label w-100">Description</label>
        <div class="col-lg-9 col-md-8">
            <textarea class="form-control" id="description" name="description" rows="6"></textarea>
        </div>
        <div class="col-lg-3 col-md-4 lh-sm">
            <small class="text-muted">
                Enter as much information possible;
                Ads with detailed and longer descriptions get more views and replies!
            </small>
        </div>

        <div class="row mt-4">
            <div class="col-auto">
                <button type="button" class="btn btn-primary" @click="submitForm">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Post My Ad
                </button>
            </div>
            <div class="col-auto  lh-sm">
                <small class="text-muted">
                    By selecting Post My Ad you agree you've read and accepted our
                    <a href="/terms" target="_blank">Terms of Use</a>.
                </small>
            </div>
        </div>
    </div>
</template>

<script>
import {watch, ref} from 'vue';
import useVuelidate from '@vuelidate/core';
import {maxLength, required} from "@vuelidate/validators";

export default {
    setup() {
        const price1 = ref('price');
        watch(price1, (val) => {
            console.log(val);
        })

        return {v$: useVuelidate()};
    },

    data: () => ({
        title: '',
        price: undefined,
        property_type: undefined,
    }),

    validations: () => ({
        title: {
            required,
            max: maxLength(10),
        },
        price: {
            required,
        },
        property_type: {
            required,
        }
    }),

    // watch: {
    //     price(val) {
    //         val = val.replace(/[^0-9,.]+/g, '');
    //         this.price = val;
    //
    //         // if (val.match(/\.[0-9]{2}.+/)) {
    //         //     val = val.replace(/(\.[0-9]{2}).+/, '$1');
    //         // }
    //
    //         // val = new Intl.NumberFormat('en-US').format(val);
    //     }
    // },

    methods: {
        submitForm() {
            this.v$.$validate().then((res) => {
                if (res) {
                    console.log(this.data);
                } else {
                    return false;
                }
            })
        }
    }
}
</script>
