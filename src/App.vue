<template>
  <div class="container">
    <OpenStreetMap />
    <Test />
    <Test2 />
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { mapActions } from 'vuex';
import 'bootstrap/dist/css/bootstrap.min.css';
import FETCH_DRAWINGS from './store/action-types';
import Test from './components/Test.vue';
import Test2 from './components/Test2.vue';
import OpenStreetMap from './components/OpenStreetMap.vue';

@Options({
  components: {
    OpenStreetMap,
    Test,
    Test2,
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
