<style lang="stylus">
  @import "~styles/main"
  @import "~flexstyl/index"

  body
    margin 1em 1.5em
    overflow-x hidden
    background color
    font-family 'Rajdhani', bold, sans-serif
    main
      @extend .flex, .center, .fwrap, .around
      > *
        margin .5em
      section
        @extend .flex, .acenter, .between, .fcolumn

        .section
          @extend .flex, .acenter, .w-around
          background none
          shadow 0
          > div
            margin .5em

        > *
          margin .5em
</style>

<template lang="jade">
.weather
  link(href='https://fonts.googleapis.com/css?family=Rajdhani:400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css')
  material
  navbar(name='Pogoda Skałągi')
  main
    humidity
    temperature
    //vial
    section
      .section
        forecast
        barometer
      wind-section

  cloud(v-for='n in 7')
</template>

<script>
  import windSection from './components/wind-section';
  import temperature from './components/temperature';
  import termometer from './components/termometer';
  import barometer from './components/barometer';
  import forecast from './components/forecast';
  import humidity from './components/humidity';
  import navbar from './components/navbar';
  import cloud from './components/cloud';
  import vial from './components/vial';
  import Basic from './api/basic';

  import material from './components/material';

  export default {
    components: {
      windSection,
      temperature,
      barometer,
      humidity,
      forecast,
      material,
      navbar,
      cloud,
      vial,
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

    ready() {
      this.api.basic.init(this.env == 'production' ? '/api' : this.api.source);
    },
  };

</script>
