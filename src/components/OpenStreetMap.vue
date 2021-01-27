<template>
  <div class="map" ref="map"></div>
  <div class="ol-popup" ref="popup" :style="{ display: this.popupDisplay }">
    <a @click="closePopup" href="#" class="ol-popup-closer"></a>
    <div>
      <img v-bind:src="`images/drawings/${this.popupImageFile}`" class="ol-popup-image" alt="...">
      <h4 ref="popup-title" class="ol-popup-title">{{this.popupTitle}}</h4>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapState } from 'vuex';
import {
  Feature, Map, Overlay, View,
} from 'ol';
import * as olExtent from 'ol/extent';
import { Geometry, Point } from 'ol/geom';
import { Tile, Vector as VectorLayer } from 'ol/layer';
import { fromLonLat } from 'ol/proj';
import { Cluster, OSM, Vector as VectorSource } from 'ol/source';
import {
  Circle as CircleStyle, Fill, Stroke, Style, Text,
} from 'ol/style';
import { Pixel } from 'ol/pixel';
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
      popupOverlay: {} as Overlay,
      popupDisplay: 'none',
      popupImageFile: '',
      popupTitle: '',
      styleCache: {} as StyleCache,
    };
  },
  methods: {
    closePopup() {
      this.popupOverlay.setPosition(undefined);
    },
    createMap() {
      this.popupOverlay = new Overlay({
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
        overlays: [this.popupOverlay],
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
            this.popupDisplay = 'block';
            this.popupImageFile = markerFeatures[0].get('imageFile');
            this.popupTitle = markerFeatures[0].get('title');
            this.popupOverlay.setPosition(coordinate);
          } else if (markerFeatures.length > 1) {
            this.zoomToCluster(pixel);
          } else {
            this.popupDisplay = 'none';
            this.popupOverlay.setPosition(undefined);
          }
        } else {
          this.popupDisplay = 'none';
          this.popupOverlay.setPosition(undefined);
        }
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
        const {
          image_file: imageFile, latitude, longitude, title,
        } = drawing;
        const feature = new Feature({
          geometry: new Point(fromLonLat([longitude, latitude])),
          imageFile,
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
    zoomToCluster(pixel: Pixel) {
      const feature = this.map.forEachFeatureAtPixel(pixel, (feat) => feat);
      if (feature) {
        const features = feature.get('features');
        if (features.length > 1) {
          const extent = olExtent.createEmpty();
          features.forEach((feat: Feature) => {
            const geometry: (Geometry|undefined) = feat.getGeometry();
            if (geometry) {
              olExtent.extend(extent, geometry.getExtent());
              this.map.getView().fit(extent);
            }
          });
        }
      }
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
.map {
  height: 500px;
  width: 100%;
}
.ol-popup {
  position: absolute;
  background-color: white;
  -webkit-filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
  filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
  padding: 30px 15px 5px 15px;
  border-radius: 5px;
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
.ol-popup-image {
  max-width: 200px;
  margin: 0 0 5px 0;
}
.ol-popup-title {
  font-size: 16px;
}
</style>
