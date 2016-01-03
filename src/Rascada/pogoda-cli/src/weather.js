import Vue from 'vue';
import weather from './weather.vue';

import slide from 'vue/transition/slide';

Vue.transition('slide', slide);

if (process.env.NODE_ENV != 'production')
  Vue.config.debug = true;

new Vue({
  el: 'body',
  components: {
    weather,
  },
});
