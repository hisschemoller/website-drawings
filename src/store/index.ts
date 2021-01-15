import { createStore } from 'vuex';
import FETCH_DRAWINGS from './action-types';
import Drawing from '../interfaces/Drawing';

export default createStore({
  state: {
    drawings: Array<Drawing>(),
  },
  mutations: {
    setDrawings(state, drawings: Drawing[]) {
      state.drawings = drawings;
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
  },
  getters: {},
  modules: {},
});
