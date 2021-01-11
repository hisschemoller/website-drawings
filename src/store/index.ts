import { createStore } from 'vuex';

export default createStore({
  state: {
    drawings: [],
  },
  mutations: {
    setDrawings(state, drawings) {
      state.drawings = drawings;
    },
  },
  actions: {
    async getDrawings(context) {
      try {
        const response = await fetch('http://localhost:8080/api/index.php');
        const json = await response.json();
        context.commit('setDrawings', json);
      } catch (err) {
        console.log('getDrawings error:', err);
      }
    },
  },
  getters: {
    drawings: (state) => state.drawings,
  },
  modules: {
  },
});
