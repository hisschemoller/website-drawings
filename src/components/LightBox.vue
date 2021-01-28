<template>
  <div class="lb-overlay">
    <div class="lb-inner">
      <div class="lb-slider"></div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue';

const LightBox = defineComponent({});
export default LightBox;
</script>

<style scoped>
  .lb-overlay {
    align-items: center;
    background-color: rgba(30, 30, 30, 0.9);
    bottom: 0;
    display: none;
    justify-content: center;
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    transition: all .3s ease;
    z-index: 9999;
  }
  .lb-overlay--show {
    display: flex;
  }
  .lb-inner {
    bottom: 0;
    left: 0;
    overflow: hidden;
    padding: 60px 0;
    position: absolute;
    right: 0;
    top: 0;
  }
  .lb-slider {
    align-items: center;
    display: flex;
    height: 100%;
    position: relative;
    width: 100%;
  }
</style>
