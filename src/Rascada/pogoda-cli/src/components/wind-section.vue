<template lang='jade'>

.windWraper
  h1 Wiatr
  select(v-model='wind.choice')
    option(selected) aktualny
    option powiew
  .wind
    gauge(:speed='5')
    compass(:direction='current.direction')

</template>

<script>
  import compass from './compass.vue'
  import gauge from './gauge.vue'

  export default {
    components: {
      compass,
      gauge,
    },

    data(){
      return {
        wind: {
          choice: '',
          actual: {
            direction: null,
          },
          gust: {
            direction: null,
          },
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
    h1
      margin .1em
    .wind
      @extend .flex, .acenter

</style>
