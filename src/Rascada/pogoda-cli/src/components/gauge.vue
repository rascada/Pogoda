<template lang='jade'>
  .gauge
    .dot
      .pointer
      .measureWrapper
        .unit(v-for='n in measure.range' v-bind:style='unitPosition(n)')
</template>

<script>
  export default {
    props: {
      speed: Number,
    },

    data() {
      return {
        measure: {
          range: 5,
        }
      }
    },

    methods: {
      unitPosition(n) {
        let rotation = -135 + ((n) * this.measureSpace);
        return {transform: `rotate(${rotation}deg)`};
      },
    },

    computed: {
      measureSpace() {
        return 270 / (this.measure.range - 1);
      },
    },
  }
</script>

<style lang='stylus'>
  @import '~styles/main'

  .gauge
    gauge-radius = 6.5em
    @extend .flex, .center
    margin .25em
    width (gauge-radius * 2)
    height @width
    color color
    border-radius 50%
    border .1em solid
    .dot
      @extend .flex, .center
      width .5em
      height @width
      background color
      border-radius 50%
      position relative
      .pointer
        background color
        position absolute
        border-radius .5em
        align-self flex-start
        height 6em; width .25em
        margin-left -.15em; margin-top 50%
        transform-origin top; transform rotate(45deg)
      .measureWrapper
        margin-left -.075em
        height gauge-radius
        position absolute
        width .1em
        bottom 50%
        .unit
          position absolute
          width 100%
          height 100%
          transform-origin bottom; transform rotate(-135deg)
          &:after
            content ''
            width 100%
            height 1em
            top 0; left 0
            background #333
            position absolute

</style>
