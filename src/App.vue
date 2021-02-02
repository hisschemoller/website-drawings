<template>
  <div class="container">
    <OpenStreetMap />
    <TileGrid />
    <vue-easy-lightbox
      escDisabled
      moveDisabled
      :visible="selectedIndex > -1"
      :imgs="visibleDrawings"
      :index="selectedIndex"
      @hide="closeLightBox"
    ></vue-easy-lightbox>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { mapActions, mapGetters, mapState } from 'vuex';
import 'bootstrap/dist/css/bootstrap.min.css';
import VueEasyLightbox from 'vue-easy-lightbox';
import { FETCH_DRAWINGS, SELECT_DRAWING } from './store/action-types';
import OpenStreetMap from './components/OpenStreetMap.vue';
import TileGrid from './components/TileGrid.vue';

@Options({
  components: {
    OpenStreetMap,
    TileGrid,
    VueEasyLightbox,
  },
  computed: {
    ...mapState(['drawings']),
    ...mapGetters(['selectedIndex', 'visibleDrawings']),
  },
  methods: {
    ...mapActions({
      fetchDrawings: FETCH_DRAWINGS,
      selectDrawing: SELECT_DRAWING,
    }),
    closeLightBox() {
      this.selectDrawing({ id: null });
    },
  },
  async created() {
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
