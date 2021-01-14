<template>
  <div class="container">
    <Test />
    <OpenStreetMap />
    <Test2 />
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { mapActions, mapState } from 'vuex';
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
  computed: {
    ...mapState(['drawings']),
  },
  methods: {
    ...mapActions({
      fetchDrawings: FETCH_DRAWINGS,
    }),
  },
  async created() {
    // this.$store.dispatch(FETCH_DRAWINGS);
    this.fetchDrawings();
    // console.log('this.$store.state.drawings:', this.$store.state.drawings);
    console.log('drawings:', this.drawings);
  },
})
export default class App extends Vue {}
</script>

<style>
#app {
  text-align: center;
}
</style>
