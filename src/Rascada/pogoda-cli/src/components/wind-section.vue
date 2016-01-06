<template lang='jade'>

.windWraper
  .actionBar
    h1 Wiatr
    select(v-model='wind.choice')
      option(selected) aktualny
      option powiew
  .wind
    compass(:direction='current.direction')
    gauge(:speed='current.speed')

</template>

<script>
  import compass from './compass.vue'
  import gauge from './gauge.vue'

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

    ready(){
      this.$parent.api.basic.on('updated', api => {
        this.wind.actual.direction = api.wind.currentDir.value;
        this.wind.gust.direction = api.wind.gustDir.value;

        this.wind.actual.speed = api.wind.currentSpeed.value
        this.wind.gust.speed = api.wind.gustSpeed.value
      });
    }
  }
</script>

<style lang='stylus'>
  @import '~styles/main'
  @import '~styles/flex'

  .windWraper
    @extend .blockShadow
    border-radius .25em
    background #eee
    color color
    padding 1em
    text-align center
    .wind
      @extend .flex, .acenter
    .actionBar
      @extend .flex, .around, .acenter
      background #fff
      shadow(.5)
      h1
        margin .1em
      select
        cursor pointer
        outline none
        border 0
        padding .5em
        border-radius .25em
        shadow(.25)
        transition .5s
        border .1em solid transparent
        &:hover
          border .1em solid color
</style>
