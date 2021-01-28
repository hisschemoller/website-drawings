<template>
  <div class="container">
    <OpenStreetMap />
    <TileGrid />
  </div>
  <LightBox />
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { mapActions } from 'vuex';
import 'bootstrap/dist/css/bootstrap.min.css';
import FETCH_DRAWINGS from './store/action-types';
import OpenStreetMap from './components/OpenStreetMap.vue';
import TileGrid from './components/TileGrid.vue';
import LightBox from './components/LightBox.vue';

@Options({
  components: {
    LightBox,
    OpenStreetMap,
    TileGrid,
  },
  methods: {
    ...mapActions({
      fetchDrawings: FETCH_DRAWINGS,
    }),
  },
  async created() {
    // this.$store.dispatch(FETCH_DRAWINGS);
    this.fetchDrawings();
  },
})
export default class App extends Vue {}
</script>

<style>
#app {
  text-align: center;
}
</style>
