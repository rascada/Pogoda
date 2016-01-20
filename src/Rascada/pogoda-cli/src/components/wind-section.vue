<template lang='jade'>

.windWraper
  .actionBar
    h1 Wiatr
    select(v-model='wind.choice')
      option(selected) aktualny
      option powiew
  .wind
    compass(:direction='current.direction')
    gauge(:value='current.speed' unit-name='km/h')

</template>

<script>
  import compass from './compass'
  import gauge from './gauge'

  import model from './model/wind'

  export default {
    components: {
      compass,
      gauge,
    },

    data(){
      return {
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

    methods: {
      setWind(which, direction, speed) {
        Object.assign(this.wind[which], {
          direction: direction.value,
          speed: speed.value,
        });
      },

      handleApi(api) {
        let wind = api.wind;

        this.setWind('actual', wind.currentDir, wind.currentSpeed);
        this.setWind('gust', wind.gustDir, wind.gustSpeed);
      },
    },

    ready(){
      this.$parent.api.basic.on('updated', this.handleApi.bind(this));
    }
  }
</script>

<style lang='stylus'>
  @import '~styles/main'
  @import '~flexstyl/index'
  @import '~styles/section'

  .windWraper
    @extend .section
    .wind
      @extend .flex, .acenter
    .actionBar
      @extend .flex, .around, .acenter
      background #fff
      shadow(.5)
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
