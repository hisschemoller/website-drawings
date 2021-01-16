<template>
  <div class="row row-cols-3 row-cols-md-3 g-4">
    <div class="col" v-for="drawing in drawings" v-bind:key="drawing.id">
      <div class="card">
        <img v-bind:src="`images/drawings/${drawing.image_file}`" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">{{drawing.description}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapState } from 'vuex';

const TileGrid = defineComponent({
  computed: {
    ...mapState(['drawings']),
  },
});
export default TileGrid;
</script>
