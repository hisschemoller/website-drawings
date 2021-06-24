<template>
  <div class="card-columns mt-4">
    <div class="card" v-for="drawing in visibleDrawings" v-bind:key="drawing.id">
      <img v-bind:src="drawing.srcSmall" @click="imageClickHandler(drawing.id)"
      class="card-img-top" alt="drawing.title">
      <div class="card-body">
        <p class="card-text">{{drawing.description}}</p>
        <p class="card-text">{{drawing.dateFormatted}}</p>
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
.card {
  border: none;
}
.card-img-top {
  cursor: pointer;
}
.card-body {
  padding-bottom: 0.8rem;
  padding-top: 0.5rem;
}
.card-text {
  margin-bottom: 0;
}
.card-text:last-of-type {
  color: #bbb;
  font-style: italic;
}
</style>
