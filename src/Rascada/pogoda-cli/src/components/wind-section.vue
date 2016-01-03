<template lang='jade'>

.windWraper
  h1 Wiatr
  select(v-model='wind.direction')
    option(:value='wind.actual') aktualny
    option(:value='wind.gust') powiew
  .wind
    compass(:direction='wind.direction || bug')

</template>

<script>
  import compass from './compass.vue'

  export default {
    components: {
      compass
    },

    data(){
      return {
        wind: {
          direction: undefined,
          gust: null,
          actual: null,
        }
      }
    },

    computed: {
      bug() {
        return typeof this.wind.direction == 'undefined' ? this.wind.actual : null;
      },
    },

    ready(){
      this.$parent.api.basic.on('updated', api => {
        this.wind.actual = api.wind.currentDir.value;
        this.wind.gust = api.wind.gustDir.value;
      });
    }
  }
</script>

<style lang='stylus'>
  @import '~styles/main'

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
      display flex

</style>
