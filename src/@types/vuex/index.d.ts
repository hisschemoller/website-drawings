import { ComponentCustomProperties } from 'vue';
import { Store } from 'vuex';
import Drawing from '../../interfaces/Drawing';

declare module '@vue/runtime-core' {
  // declare your own store states
  interface State {
    items: Drawing[];
    selectedIndex: number;
  }

  // provide typings for `this.$store`
  interface ComponentCustomProperties {
    $store: Store<State>;
  }
}
