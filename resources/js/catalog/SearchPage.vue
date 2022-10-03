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
      const center = [-6.29726611, 53.34677576];
      const zoom = 11;
      const style = "mapbox://styles/mapbox/streets-v11";
      map.value = new mapboxgl.Map({container: "map", style, center, zoom});
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
