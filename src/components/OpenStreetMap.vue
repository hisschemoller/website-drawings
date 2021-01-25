<template>
  <div class="map" id="map" ref="map"></div>
  <div id="popup" class="ol-popup" ref="popup" style="display:">
    <a href="#" id="popup-closer" class="ol-popup-closer"></a>
    <div id="popup-content"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapState } from 'vuex';
import {
  Feature, Map, Overlay, View,
} from 'ol';
import { Point } from 'ol/geom';
import { Tile, Vector as VectorLayer } from 'ol/layer';
import { fromLonLat } from 'ol/proj';
import { Cluster, OSM, Vector as VectorSource } from 'ol/source';
import {
  Circle as CircleStyle, Fill, Stroke, Style, Text,
} from 'ol/style';
import 'ol/ol.css';
import Drawing from '../interfaces/Drawing';

interface StyleCache {
  [name: string]: Style;
}

const OpenStreetMap = defineComponent({
  computed: {
    ...mapState(['drawings']),
  },
  data() {
    return {
      clusterLayer: {} as VectorLayer,
      map: {} as Map,
      overlay: {} as Overlay,
      styleCache: {} as StyleCache,
    };
  },
  methods: {
    createMap() {
      this.overlay = new Overlay({
        element: this.$refs.popup as HTMLElement,
        autoPan: true,
        autoPanAnimation: {
          duration: 250,
        },
      });

      const tileLayer = new Tile({
        source: new OSM(),
      });

      this.map = new Map({
        layers: [tileLayer],
        target: this.$refs.map as HTMLElement,
        view: new View({
          center: [0, 0],
          constrainResolution: true,
          zoom: 0,
        }),
      });

      // show popup on marker click
      // https://stackoverflow.com/questions/62358299/openlayers-6-marker-popup-without-nodejs
      this.map.on('singleclick', (e) => {
        const { coordinate, pixel } = e;
        const clusterFeatures = this.map.getFeaturesAtPixel(pixel);
        if (clusterFeatures.length) {
          const markerFeatures = clusterFeatures[0].get('features');

          // a cluster with one marker is a regular marker
          if (markerFeatures.length === 1) {
            console.log('title', markerFeatures[0].get('title'));
            console.log('coordinate', coordinate);
            // popup.style.display = 'block';
            this.overlay.setPosition(coordinate);
          }
        }
        // if (name) {
        //   container.style.display = 'block';
        //   var coordinate = evt.coordinate;
        //   content.innerHTML = name;
        //   overlay.setPosition(coordinate);
        // } else {
        //   container.style.display = 'none';
        // }
      });
    },
    updateMarkers(newDrawings: Drawing[]) {
      const features: Feature[] = [];

      // remove the old markers
      if (this.clusterLayer) {
        this.map.removeLayer(this.clusterLayer);
      }

      // add the new markers
      newDrawings.forEach((drawing) => {
        const { latitude, longitude, title } = drawing;
        const feature = new Feature({
          geometry: new Point(fromLonLat([longitude, latitude])),
          title,
        });
        features.push(feature);
      });

      const source = new VectorSource({
        features,
      });

      const clusterSource = new Cluster({
        distance: 50,
        source,
      });

      this.clusterLayer = new VectorLayer({
        source: clusterSource,
        style: (feature) => {
          const size = feature.get('features').length;
          let style: Style = this.styleCache[size];
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
            this.styleCache[size] = style;
          }
          return style;
        },
      });

      this.map.addLayer(this.clusterLayer);
    },
  },
  mounted() {
    this.createMap();
  },
  watch: {
    drawings(newValue) {
      this.updateMarkers(newValue);
    },
  },
});
export default OpenStreetMap;
</script>

<style>
#map {
  height: 500px;
  width: 100%;
}
.ol-popup {
  position: absolute;
  background-color: white;
  -webkit-filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
  filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
  padding: 15px;
  border-radius: 10px;
  border: 1px solid #cccccc;
  bottom: 12px;
  left: -50px;
  min-width: 80px;
}
.ol-popup:after,
.ol-popup:before {
  top: 100%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
}
.ol-popup:after {
  border-top-color: white;
  border-width: 10px;
  left: 48px;
  margin-left: -10px;
}
.ol-popup:before {
  border-top-color: #cccccc;
  border-width: 11px;
  left: 48px;
  margin-left: -11px;
}
.ol-popup-closer {
  text-decoration: none;
  position: absolute;
  top: 2px;
  right: 8px;
}
.ol-popup-closer:after {
  content: "x";
}

</style>
