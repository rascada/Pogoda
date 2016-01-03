<style lang="stylus">
  @import url("https://fonts.googleapis.com/css?family=Rajdhani:400,600&amp;subset=latin,latin-ext");
  @import "~styles/main"
  @import "~styles/flex"

  body
    margin 1em 1.5em
    overflow-x hidden
    background color
    font-family 'Rajdhani', bold, sans-serif
    main
      @extend .flex, .center, .fwrap, .around
</style>

<template lang="jade">

navbar(name='Pogoda Skałągi')
main
  forecast
  wind-section
  termometer

</template>

<script>
  import windSection from './components/wind-section.vue'
  import termometer from './components/termometer.vue'
  import forecast from './components/forecast.vue'
  import navbar from './components/navbar.vue'
  import vial from './components/vial.vue'
  import Basic from './api/basic';

  export default {
    components: {
      windSection,
      termometer,
      navbar,
      vial,
      forecast,
    },

    data() {
      return {
        env: process.env.NODE_ENV,
        api: {
          source: 'https://pogoda.skalagi.pl/api',
          basic: new Basic(),
        },
      };
    },

    ready(){
      this.api.basic.init(this.env == 'production' ? '/api' : this.api.source);
    },
  }
</script>
