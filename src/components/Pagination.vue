<template>
  <nav class="pagination">
    <ul class="page-numbers" v-if="numPages > 1">
      <li
        v-for="nr in numPages"
        :key="nr"
        >
        <span v-if="nr === pageIndex + 1" class="current">{{nr}}</span>
        <a v-else href="#" @click="setPage(nr - 1)">{{nr}}</a>
      </li>
    </ul>
  </nav>
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
/* .pagination {
  border-radius: 0;
  display: flex;
  justify-content: center;
  list-style: none;
  padding-left: 0;
}
.page-item {
  margin: 5px;
}
.page-link {
  display: block;
  line-height: 1.25;
  padding: .5rem .75rem;
  position: relative;
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
  color: #fff;
  z-index: 3;
} */
</style>
