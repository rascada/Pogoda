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
link(href='https://fonts.googleapis.com/css?family=Rajdhani:400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css')

navbar(name='Pogoda Skałągi')
main
  humidity
  temperature
  //vial
  section
    div.section
      forecast
      barometer
    wind-section

</template>

<script>
  import windSection from './components/wind-section';
  import temperature from './components/temperature';
  import termometer from './components/termometer';
  import forecast from './components/forecast';
  import navbar from './components/navbar';
  import humidity from './components/humidity';
  import barometer from './components/barometer';
  import vial from './components/vial';
  import Basic from './api/basic';

  export default {
    components: {
      windSection,
      temperature,
      navbar,
      barometer,
      humidity,
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

    ready() {
      this.api.basic.init(this.env == 'production' ? '/api' : this.api.source);
    },
  };

</script>
