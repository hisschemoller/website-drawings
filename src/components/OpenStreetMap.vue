<template>
  <div class="map" id="map"></div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapState } from 'vuex';
import { Feature, Map, View } from 'ol';
import { Point } from 'ol/geom';
import { Tile, Vector as VectorLayer } from 'ol/layer';
import { fromLonLat } from 'ol/proj';
import { OSM, Vector as VectorSource } from 'ol/source';
import { Icon, Style } from 'ol/style';
import 'ol/ol.css';
import Drawing from '../interfaces/Drawing';

let map: Map;
let markerLayer: VectorLayer;

const markerStyle = new Style({
  image: new Icon({
    color: 'rgba(255, 0, 0, .5)',
    crossOrigin: 'anonymous',
    scale: 0.1,
    src: 'https://upload.wikimedia.org/wikipedia/commons/e/e3/Green_Dot.svg',
  }),
});

function createMap(): void {
  map = new Map({ // eslint-disable-line no-new
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
}

function updateMarkers(newDrawings: Drawing[]): void {
  const features: Feature[] = [];

  // remove the old markers
  if (markerLayer) {
    map.removeLayer(markerLayer);
  }

  // add the new markers
  newDrawings.forEach((drawing) => {
    const { latitude, longitude } = drawing;
    const feature = new Feature({
      geometry: new Point(fromLonLat([longitude, latitude])),
    });
    feature.setStyle(markerStyle);
    features.push(feature);
  });

  markerLayer = new VectorLayer({
    source: new VectorSource({
      features,
    }),
  });
  map.addLayer(markerLayer);
}

const OpenStreetMap = defineComponent({
  computed: {
    ...mapState(['drawings']),
  },
  mounted() {
    createMap();
  },
  watch: {
    drawings(newValue) {
      updateMarkers(newValue);
    },
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
