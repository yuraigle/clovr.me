<template>
    <div class="d-flex d-flex-row mb-4">
        <div>
            <input
                id="_postcode"
                type="text"
                v-model="postcode"
                class="form-control"
                :class="{ 'is-invalid': v$['postcode'].$error }"
                placeholder="Postal Code"
                style="width: 110px"
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
            <button class="btn btn-outline-secondary" type="button" @click="locate1()">
                <i class="fa-solid fa-location-arrow"></i>
            </button>
        </div>
    </div>

    <div class="w-100">
        <div id="map" style="height: 500px"></div>
    </div>

</template>

<script>
import {onMounted, ref} from "vue";
import useVuelidate from "@vuelidate/core";
import {maxLength} from "@vuelidate/validators";
import mapboxgl from "mapbox-gl";
// import "mapbox-gl/dist/mapbox-gl.css";

export default {
    setup() {
        const postcode = ref("");
        const county = ref("");
        const town = ref("");
        const address = ref("");
        const v$ = useVuelidate();

        mapboxgl.accessToken =
            "pk.eyJ1IjoieXVyYWlnbGUiLCJhIjoiY2wwZmUzdTNnMHJ5eTNubzZpOXEzNGFrayJ9.vK2h-JCIge6NaEABNtPxvw";

        const map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [-6.25, 53.35],
            zoom: 11
        });

        const marker = new mapboxgl.Marker({draggable: true});

        onMounted(() => {
            map.on('click', function (e) {
                marker.setLngLat(e.lngLat).addTo(map);
                locate2(e.lngLat);
            })

            marker.on('dragend', function (e) {
                locate2(e.target._lngLat);
            })

        });

        function locate1() {
            const query = new URLSearchParams({
                types: 'address',
                country: 'ie',
                region: county.value,
                postcode: postcode.value,
                place: town.value,
                access_token: mapboxgl.accessToken,
                limit: 1,
            });

            const str = [postcode.value, county.value, town.value, address.value].join(' ');
            const url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
                + encodeURIComponent(str) + '.json?' + query.toString();

            fetch(url)
                .then((res) => res.json())
                .then((data) => {
                    if (data && data.features && data.features.length > 0) {
                        const f = data.features[0];
                        marker.setLngLat(f.center).addTo(map);
                        map.jumpTo({center: f.center, zoom: 16});
                    } else {
                        console.log('Nothing');
                    }
                });
        }

        function locate2({lng, lat}) {
            const query = new URLSearchParams({
                types: 'address',
                country: 'ie',
                access_token: mapboxgl.accessToken,
            });

            const url2 = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
                + lng + ',' + lat + '.json?' + query.toString();

            fetch(url2)
                .then((res) => res.json())
                .then((data) => {
                    if (!data || !data.features) return;

                    address.value = data.features[0].text;
                    for (let c of data.features[0].context) {
                        if (c.id.startsWith('postcode.')) postcode.value = c.text;
                        if (c.id.startsWith('region.')) county.value = c.text;
                        if (c.id.startsWith('place.')) town.value = c.text;
                    }
                });
        }

        return {
            postcode,
            county,
            town,
            address,
            v$,
            locate1,
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
