<template>
  <ul class="pagination" v-if="numPages > 1">
    <li
      v-for="nr in numPages"
      :key="nr"
      class="page-item"
      :class="{ active: nr === pageIndex + 1 }"
      @click="setPage(nr - 1)"
      >
      <a class="page-link" href="#">{{nr}}</a>
    </li>
  </ul>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapMutations, mapGetters, mapState } from 'vuex';

const Pagination = defineComponent({
  computed: {
    ...mapState(['pageIndex']),
    ...mapGetters(['numPages']),
  },
  methods: {
    ...mapMutations(['setPage']),
  },
});
export default Pagination;
</script>

<style>
.pagination {
  border-radius: 0;
  justify-content: center;
}
.page-item {
  margin: 5px;
}
.page-link,
.page-link:hover {
  color: #000;
}
.page-link:focus {
  box-shadow: none;
}
.page-item.active .page-link {
  background-color: #aaa;
  border: none;
}
</style>
