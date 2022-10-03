<template>
  <table>
    <tr style="height: 47px; border-bottom: 1px solid #ccc">
      <td colspan="2">
        <SearchFilter :filter="filter"/>
      </td>
    </tr>
    <tr>
      <td style="width: 270px; border-right: 1px solid #ccc; vertical-align: top">
        <div id="prop" class="p-3">
          <p class="text-center text-muted"><small>No offers in the selected area.</small></p>
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

    onMounted(() => {
      const center = [-6.29726611, 53.34677576]; // todo depend on town
      const zoom = 11;
      const style = "mapbox://styles/mapbox/streets-v11";
      map.value = new mapboxgl.Map({container: "map", style, center, zoom});

      map.value.on("load", function (e) {

        map.value.loadImage(
          '/marker-icon.png',
          (error, image) => {
            if (error) throw error;
            map.value.addImage('marker', image);
          }
        );

        map.value.addSource('houses', {
          type: 'geojson',
          data: '/markers',
          cluster: true,
          clusterMaxZoom: 14,
          clusterRadius: 50
        });

        map.value.addLayer({
          id: 'clusters',
          type: 'circle',
          source: 'houses',
          filter: ['has', 'point_count'],
          paint: {
            'circle-color': ['step', ['get', 'point_count'], '#aad651', 10, '#f1e775'],
            'circle-radius': ['step', ['get', 'point_count'], 20, 10, 25]
          }
        });

        map.value.addLayer({
          id: 'cluster-count',
          type: 'symbol',
          source: 'houses',
          filter: ['has', 'point_count'],
          layout: {
            'text-field': '{point_count_abbreviated}',
          }
        });

        map.value.addLayer({
          id: 'unclustered-point',
          type: 'symbol',
          source: 'houses',
          filter: ['!', ['has', 'point_count']],
          layout: {
            'icon-image': 'marker',
          }
        });

        map.value.on('click', 'clusters', (e) => {
          const features = map.value.queryRenderedFeatures(e.point, {
            layers: ['clusters']
          });
          const clusterId = features[0].properties.cluster_id;
          map.value.getSource('houses').getClusterExpansionZoom(
            clusterId,
            (err, zoom) => {
              if (err) return;

              map.value.easeTo({
                center: features[0].geometry.coordinates,
                zoom: zoom
              });
            }
          );
        });

        map.value.on('click', 'unclustered-point', (e) => {
          const coordinates = e.features[0].geometry.coordinates.slice();
          const prop = e.features[0].properties;

          let img1 = '/s_noimg.webp';
          if (prop['pic']) {
            img1 = `/images/${prop['pic'].substring(0, 4)}/s_${prop['pic']}.webp`;
          }

          new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(`<a href="${prop.url}"><img src="${img1}" alt=""/></a>`)
            .addTo(map.value);
        });

        // reloadMarkers();
      });

      map.value.on("moveend", function (e) {
        // reloadMarkers();
      });

      function reloadMarkers() {
        const center = map.value.getCenter();
        console.log(center);

        const urlParams = new URLSearchParams({
          lng: 0,
          lat: 0
        });

        const url = '/markers?' + urlParams.toString();
        fetch(url, {})
          .then((r) => r.json().then((d) => ({status: r.status, body: d})))
          .then((result) => {
            if (result.status === 200) {
              for (let m of result.body) {
                console.log(m);
              }
            }
          })
          .catch((err) => {
            console.error(err);
          });
      }
    });

    return {
      filter,
      map,
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
</style>
