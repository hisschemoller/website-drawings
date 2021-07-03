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
.mt-4 {
  margin-top: 1.5rem;
}
@media (min-width: 576px) {
  .card-columns {
    -moz-column-count: 3;
    column-count: 3;
    -moz-column-gap: 1.25rem;
    column-gap: 1.25rem;
    orphans: 1;
    widows: 1;
  }
  .card-columns .card {
    display: inline-block;
    width: 100%;
  }
}
.card {
  background-clip: border-box;
  border: none;
  display: flex;
  flex-direction: column;
  min-width: 0;
  position: relative;
  word-wrap: break-word;
}
.card-img-top {
  cursor: pointer;
  display: block;
  flex-shrink: 0;
  width: 100%;
}
.card-body {
  flex: 1 1 auto;
  min-height: 1px;
  padding: 0.5rem 1.25rem 1.25rem 1.25rem;
}
.card-text {
  line-height: 1.2rem;
  margin: 0.5rem 0 1rem 0;
  padding: 0;
}
.card-text:last-of-type {
  color: #bbb;
  font-style: italic;
  margin-top: -0.5rem;
}
</style>
