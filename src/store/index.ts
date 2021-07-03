import { createStore } from 'vuex';
import { FETCH_DRAWINGS, SELECT_DRAWING, UPDATE_VISIBLE_DRAWINGS } from './action-types';
import Drawing from '../interfaces/Drawing';

export default createStore({
  state: {
    env: 'live', // 'dev' | 'live'
    drawings: Array<Drawing>(),
    pageIndex: 0,
    pageSize: 30,
    selectedId: '',
    visibleIds: Array<string>(),
  },
  mutations: {
    setDrawings(state, drawings: Drawing[]) {
      state.drawings = drawings.map((drawing) => {
        const date = new Date(drawing.date);
        return {
          ...drawing,
          src: `/images/drawings/${drawing.image_file_large}`,
          srcSmall: `/images/drawings/${drawing.image_file_small}`,
          dateFormatted: `${new Intl.DateTimeFormat('nl', { day: 'numeric' }).format(date)} 
            ${new Intl.DateTimeFormat('nl', { month: 'long' }).format(date)} 
            ${new Intl.DateTimeFormat('nl', { year: 'numeric' }).format(date)}`,
        };
      });
    },
    setPage(state, index: number) {
      console.log('setPage', index);
      state.pageIndex = index;
    },
    setSelectedId(state, id: string) {
      state.selectedId = id;
    },
    setVisibleDrawings(state, visibleIds) {
      state.visibleIds = visibleIds;
      state.pageIndex = 0;
    },
  },
  actions: {
    async [FETCH_DRAWINGS]({ commit, state }) {
      try {
        // const response = await fetch('http://localhost:8080/api/index.php');
        const response = await fetch(state.env === 'dev'
          ? ' json/drawings.json'
          : '/website-drawings/json/drawings.json');
        const json = await response.json();
        commit('setDrawings', json);
      } catch (err) {
        console.log('getDrawings error:', err);
      }
    },
    [SELECT_DRAWING]({ commit }, { id }) {
      commit('setSelectedId', id);
    },
    [UPDATE_VISIBLE_DRAWINGS]({ commit }, { visibleIds }) {
      commit('setVisibleDrawings', visibleIds);
    },
  },
  getters: {
    numPages: (state) => Math.ceil(state.visibleIds.length / state.pageSize),
    selectedIndex: (state, getters) => getters.visibleDrawings.findIndex(
      (drawing: Drawing) => drawing.id === state.selectedId,
    ),
    visibleDrawings: ({
      drawings, pageIndex, pageSize, visibleIds,
    }) => {
      const pageOfIDs = visibleIds.slice(pageIndex * pageSize, (pageIndex + 1) * pageSize);
      // eslint-disable-next-line arrow-body-style
      return pageOfIDs.map((id: string) => {
        return drawings.find((drawing: Drawing) => drawing.id === id);
      });
    },
  },
  modules: {},
});
