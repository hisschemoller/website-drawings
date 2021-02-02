import { createStore } from 'vuex';
import { FETCH_DRAWINGS, SELECT_DRAWING } from './action-types';
import Drawing from '../interfaces/Drawing';

export default createStore({
  state: {
    drawings: Array<Drawing>(),
    selectedId: '',
  },
  mutations: {
    setDrawings(state, drawings: Drawing[]) {
      state.drawings = drawings.map((drawing) => ({
        ...drawing,
        src: `images/drawings/${drawing.image_file}`,
      }));
    },
    setSelectedId(state, id: string) {
      state.selectedId = id;
    },
  },
  actions: {
    async [FETCH_DRAWINGS]({ commit }) {
      try {
        const response = await fetch('http://localhost:8080/api/index.php');
        const json = await response.json();
        commit('setDrawings', json);
      } catch (err) {
        console.log('getDrawings error:', err);
      }
    },
    [SELECT_DRAWING]({ commit }, { id }) {
      commit('setSelectedId', id);
    },
  },
  getters: {
    selectedIndex: (state, getters) => getters.visibleDrawings.findIndex(
      (drawing: Drawing) => drawing.id === state.selectedId,
    ),
    visibleDrawings: (state) => state.drawings,
  },
  modules: {},
});
