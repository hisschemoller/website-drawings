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
import { Cluster, OSM, Vector as VectorSource } from 'ol/source';
import {
  Circle as CircleStyle, Fill, Icon, Stroke, Style, Text,
} from 'ol/style';
import 'ol/ol.css';
import Drawing from '../interfaces/Drawing';

interface StyleCache {
  [name: string]: Style;
}

let map: Map;
let clusterLayer: VectorLayer;
const styleCache: StyleCache = {};
const markerStyle = new Style({
  image: new Icon({
    color: 'rgba(255, 0, 0, .5)',
    crossOrigin: 'anonymous',
    scale: 0.1,
    src: 'https://upload.wikimedia.org/wikipedia/commons/e/e3/Green_Dot.svg',
  }),
});

/**
 * Create the OpenLayers map.
 */
function createMap(): void {
  const tileLayer = new Tile({
    source: new OSM(),
  });

  map = new Map({
    layers: [tileLayer],
    target: 'map',
    view: new View({
      center: [0, 0],
      constrainResolution: true,
      zoom: 0,
    }),
  });
}

// function getStyle(feature: Feature): StyleFunction {
//   return new Style({});
// }

/**
 * Update the markers on the map.
 */
function updateMarkers(newDrawings: Drawing[]): void {
  const features: Feature[] = [];

  // remove the old markers
  if (clusterLayer) {
    map.removeLayer(clusterLayer);
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

  const source = new VectorSource({
    features,
  });

  const clusterSource = new Cluster({
    distance: 50,
    source,
  });

  clusterLayer = new VectorLayer({
    source: clusterSource,
    // eslint-disable-next-line object-shorthand, func-names
    style: function (feature): Style {
      const size = feature.get('features').length;
      let style: Style = styleCache[size];
      if (!style) {
        style = new Style({
          image: new CircleStyle({
            radius: 10,
            stroke: new Stroke({
              color: '#fff',
            }),
            fill: new Fill({
              color: size === 1 ? '#006600' : '#3399CC',
            }),
          }),
          text: new Text({
            text: size.toString(),
            fill: new Fill({
              color: '#fff',
            }),
          }),
        });
        styleCache[size] = style;
      }
      return style;
    },
  });

  map.addLayer(clusterLayer);
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
