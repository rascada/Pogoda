<style lang="stylus">
@import "~styles/main"
@import "~flexstyl/index"

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
  main
    humidity
    temperature
    //vial
    section
      .section
        barometer
        forecast
      wind-section

  cloud(v-for='n in 7')
</template>

<script>
  import windSection from './wind-section';
  import temperature from './temperature';
  import termometer from './termometer';
  import barometer from './barometer';
  import forecast from './forecast';
  import humidity from './humidity';
  import cloud from './cloud';
  import vial from './vial';

  export default {
    components: {
      windSection,
      temperature,
      barometer,
      humidity,
      forecast,
      cloud,
      vial,
    },

    data() {
      return {
        env: process.env.NODE_ENV,
        api: { },
      };
    },
  };

</script>
