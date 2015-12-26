import Vue from 'vue';
import App from './app.vue';

Vue.filter('round', require('vue/filter/round'));
Vue.transition('slide', require('vue/transition/slide'));

if (process.env.NODE_ENV != 'production')
  Vue.config.debug = true;

new Vue({
  el: 'body',
  components: {
    app: App,
  },
});
