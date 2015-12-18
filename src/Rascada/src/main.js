var Vue = require('vue');
var App = require('./app.vue');
var roundFilter = require('vue-filters/round');

Vue.filter('round', roundFilter);

new Vue({
  el: 'body',
  components: {
    app: App
  }
});
