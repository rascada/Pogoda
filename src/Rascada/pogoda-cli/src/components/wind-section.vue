<template lang='jade'>

.windWraper
  .actionBar
    h1 Wiatr
    select(v-model='wind.choice' v-bind:disabled='animation')
      option(selected) aktualny
      option powiew
  .wind
    compass(:direction='current.direction')
      span(slot='screen') {{ current.humanReadable }}
    gauge(:value='current.speed' unit-name='km/h')

</template>

<script>
  import compass from './compass';
  import gauge from './gauge';

  import model from './model/wind';

  export default {
    components: {
      compass,
      gauge,
    },

    data() {
      return {
        animation: false,
        wind: {
          choice: '',
          actual: model(),
          gust: model(),
        },
      };
    },

    computed: {
      current() {
        switch (this.wind.choice) {
          case 'powiew':
            return this.wind.gust;
          default:
            return this.wind.actual;
        };
      },
    },

    events: {
      animate(isAnimating) {
        this.animation = isAnimating;
      },
    },

    methods: {
      windDirection(fromBlow) {
        let direction = fromBlow.value + 180;

        return direction < 360 ? direction : direction - 360;
      },

      setWind(which, fromBlow, speed, humanReadable) {
        Object.assign(this.wind[which], {
          direction: this.windDirection(fromBlow),
          speed: speed.value,
          humanReadable,
        });
      },

      handleApi(api) {
        let wind = api.wind;

        this.setWind('actual', wind.currentDir, wind.currentSpeed, wind.translatedDir.current);
        this.setWind('gust', wind.gustDir, wind.gustSpeed, wind.translatedDir.gust);
      },
    },

    ready() {
      this.$parent.api.basic.on('updated', this.handleApi.bind(this));
    },
  };

</script>

<style lang='stylus'>
  @import '~styles/main'
  @import '~flexstyl/index'
  @import '~styles/section'

  .windWraper
    @extend .section
    .wind
      @extend .flex, .acenter
      .compass
        span
          font-weight 600
    .actionBar
      @extend .flex, .around, .acenter
      background #fff
      padding .5em 0
      shadow .5
      h1
        margin .1em
      select
        background #fff
        cursor pointer
        outline none
        border 0
        padding .5em
        border-radius .25em
        shadow(.5)
        transition .5s
        border .1em solid transparent
        &:hover
          border .1em solid color
</style>
