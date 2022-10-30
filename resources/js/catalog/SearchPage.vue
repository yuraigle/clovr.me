<template>
  <table class="bg-light">
    <tr style="height: 47px; border-bottom: 1px solid #ccc">
      <td colspan="2">
        <SearchFilter :filter="filter"/>
      </td>
    </tr>
    <tr>
      <td>
        <div id="map"></div>
      </td>
    </tr>
  </table>
</template>

<script>
import {onMounted, reactive, ref} from "vue";
import SearchFilter from "./SearchFilter.vue";

export default {
  components: {
    SearchFilter,
  },

  setup() {
    const filter = reactive({});
    const map = ref(null);
    const shownPoints = ref([]);

    onMounted(() => {
      const townData = JSON.parse(document.querySelector('meta[name="town"]').content);
      map.value = L.map('map', {
        zoomAnimation: false,
        attributionControl: false,
      }).setView([townData.lat, townData.lng], townData.zoom);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: window.mapboxToken
      }).addTo(map.value);


      const greenDot = L.icon({
        iconUrl: '/layout/blue-dot.svg',
        iconSize: [18, 18],
      });

      const markers = L.markerClusterGroup({
        spiderfyOnMaxZoom: false,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true
      });

      fetch("/markers")
        .then((resp) => resp.json())
        .then((data) => {
          data.features.forEach((f) => {
            const coords = f.geometry.coordinates;
            const {url, pic, title, price} = f.properties;
            const marker = L.marker([coords[1], coords[0]], {icon: greenDot});
            const html = `<a href='${url}' target="_blank" class="text-center" title="${title}">
<img src="${hash2img(pic, 's')}" class="img-thumbnail" alt="pic" width="120"/><br/>
${price_fmt(price)}</a>`;
            marker.bindPopup(html);
            markers.addLayer(marker);

            marker.on('click', function () {
              console.log('cc');
            })
          })
          map.value.addLayer(markers);
        });

      function hash2img(hash, size = 'm') {
        if (!hash) {
          return `/layout/${size}_noimg.1666414708.webp`;
        }
        return `/images/${hash.substring(0, 4)}/${size}_${hash}.webp`;
      }

      function price_fmt(n) {
        return new Intl.NumberFormat('en-IE', {
          style: 'currency',
          currency: 'EUR',
          maximumFractionDigits: 0
        }).format(n);
      }

      function price_fq(s) {
        if (s === 'per_week') {
          return '/wk';
        } else if (s === 'per_month') {
          return '/mo';
        }
        return '';
      }

      return {
        filter,
        map,
        shownPoints,
        hash2img,
        price_fmt,
        price_fq
      }
    });
  }
}
</script>

<style scoped>
table {
  width: 100%;
}

td {
  padding: 0;
}

#map {
  width: 100%;
  height: calc(100vh - 64px - 48px);
}
</style>
