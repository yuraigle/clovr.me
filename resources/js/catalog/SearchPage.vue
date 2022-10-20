<template>
  <table>
    <tr style="height: 47px; border-bottom: 1px solid #ccc">
      <td colspan="2">
        <SearchFilter :filter="filter"/>
      </td>
    </tr>
    <tr>
      <td style="width: 270px; border-right: 1px solid #ccc; vertical-align: top">
        <div id="offers" class="p-1">
          <ul v-if="shownPoints.length">
            <li v-for="p in shownPoints" :key="p.id" class="py-2 border-bottom">
              <a :href="p.url" target="_blank" class="text-dark">
                <img :src="hash2img(p.pic)" alt="pic" width="200" height="150" />
                <br/>
                {{ price_fmt(p.price) }}{{ price_fq(p.price_freq) }}
              </a>
            </li>
          </ul>
          <p v-else class="text-center text-muted"><small>No offers in the selected area.</small></p>
        </div>
      </td>
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
      const center = [-6.29726611, 53.34677576]; // todo depend on town
      const zoom = 11;
      const style = "mapbox://styles/mapbox/streets-v11";
      map.value = new mapboxgl.Map({container: "map", style, center, zoom});

      map.value.on("load", function (e) {

        map.value.addSource('houses', {
          type: 'geojson',
          data: '/markers',
          cluster: true,
          clusterMaxZoom: 14,
          clusterRadius: 50
        });

        map.value.addLayer({
          id: 'point',
          type: 'circle',
          source: 'houses',
          filter: ['!', ['has', 'point_count']],
          paint: {
            'circle-radius': 9,
            'circle-color': ['case', ['boolean', ['feature-state', 'active'], false], '#03C04A', '#985DFF'],
            'circle-stroke-width': 2,
            'circle-stroke-color': '#fff',
          },
        });

        map.value.addLayer({
          id: 'clusters',
          type: 'circle',
          source: 'houses',
          filter: ['has', 'point_count'],
          paint: {
            'circle-radius': 9,
            'circle-color': ['case', ['boolean', ['feature-state', 'active'], false], '#03C04A', '#985DFF'],
            'circle-stroke-width': 2,
            'circle-stroke-color': '#fff',
          }
        });

        map.value.addLayer({
          id: 'cluster-count',
          type: 'symbol',
          source: 'houses',
          filter: ['has', 'point_count'],
          layout: {
            'text-field': '{point_count_abbreviated}',
            'text-size': 11,
          },
          paint: {
            'text-color': '#fff',
          }
        });

        map.value.getCanvas().style.cursor = "default";

        map.value.on("mouseenter", ['clusters', 'point'], () => {
          map.value.getCanvas().style.cursor = "pointer";
        });

        map.value.on("mouseleave", ['clusters', 'point'], () => {
          map.value.getCanvas().style.cursor = "default";
        });

        let selId = null;
        map.value.on("click", ['clusters', 'point'], (e) => {
          if (e.features.length === 0) return;
          if (selId) map.value.removeFeatureState({source: 'houses', id: selId});

          selId = e.features[0].id;
          map.value.setFeatureState({source: 'houses', id: selId}, {active: true});

          shownPoints.value.length = 0;
          if (e.features[0].properties.cluster) {
            addClusterHouses(e.features[0].properties.cluster_id);
          } else {
            shownPoints.value.push(e.features[0].properties);
          }
        });
      });

      function addClusterHouses(cid) {
        if (shownPoints.value.length >= 5)
          return;

        map.value.getSource('houses').getClusterChildren(cid, function (_, f) {
          for (let f1 of f) {
            if (f1.properties && f1.properties.cluster_id && f1.properties.cluster_id !== cid) {
              addClusterHouses(f1.properties.cluster_id);
            } else if (f1.properties && f1.properties.id && shownPoints.value.length < 5) {
              shownPoints.value.push(f1.properties);
            }
          }
        });
      }
    });

    function hash2img(s) {
      if (!s) {
        return "/m_noimg.webp";
      }
      return "/images/" + s.substring(0, 4) + "/m_" + s + ".webp";
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
  height: calc(100vh - 66px - 48px);
}

#offers {
  height: calc(100vh - 66px - 48px);
  overflow-y: scroll;
}

#offers > ul {
  list-style: none;
}
</style>
