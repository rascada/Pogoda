var Vue = require('vue');
var App = require('./app.vue');

Vue.filter('round', require('vue/filter/round'));
Vue.transition('slide', require('vue/transition/slide'));

new Vue({
  el: 'body',
  components: {
    app: App,
  },
});
