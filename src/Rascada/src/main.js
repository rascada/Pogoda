var Vue = require('vue');
var App = require('./app.vue');
var roundFilter = require('vue-filters/round');
var slide = require('vue/transition/slide');

Vue.filter('round', roundFilter);
Vue.transition('slide', slide);

new Vue({
  el: 'body',
  components: {
    app: App
  }
});
