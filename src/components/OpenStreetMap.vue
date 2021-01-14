<template>
  <div class="map" id="map"></div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  Map, View,
} from 'ol';
import { OSM } from 'ol/source';
import { Tile } from 'ol/layer';

const OpenStreetMap = defineComponent({
  mounted() {
    new Map({ // eslint-disable-line no-new
      layers: [
        new Tile({ // eslint-disable-line no-new
          source: new OSM(), // eslint-disable-line no-new
        }),
      ],
      view: new View({ // eslint-disable-line no-new
        center: [0, 0],
        constrainResolution: true,
        zoom: 0,
      }),
      target: 'map',
    });
  },
});
export default OpenStreetMap;
</script>

<style>
#map {
  height: 400px;
  width: 100%;
}
</style>
