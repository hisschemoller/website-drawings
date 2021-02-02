<template>
  <div class="row row-cols-3 row-cols-md-3 g-4 mt-4">
    <div class="col" v-for="drawing in visibleDrawings" v-bind:key="drawing.id">
      <div class="card">
        <img v-bind:src="drawing.src" @click="imageClickHandler(drawing.id)"
        class="card-img-top" alt="drawing.title">
        <div class="card-body">
          <h5 class="card-title">{{drawing.title}}</h5>
          <p class="card-text">{{drawing.description}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapActions, mapGetters } from 'vuex';
import { SELECT_DRAWING } from '../store/action-types';

const TileGrid = defineComponent({
  computed: {
    ...mapGetters(['visibleDrawings']),
  },
  methods: {
    ...mapActions({
      selectDrawing: SELECT_DRAWING,
    }),
    imageClickHandler(id: string) {
      this.selectDrawing({ id });
    },
  },
});
export default TileGrid;
</script>

<style>
.card img {
  cursor: pointer;
}
</style>
