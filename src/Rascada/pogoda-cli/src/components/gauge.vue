<template lang='jade'>
  .gauge
    .dot
      .pointer(:style='pointer')
      .measureWrapper
        .unit(v-for='n in measure.range' v-bind:style='unitPosition(n)')
          p {{ $index * measure.unit }}
</template>

<script>
  export default {
    props: {
      speed: Number,
    },

    data() {
      return {
        measure: {
          range: 12,
          unit: 3,
        },
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

      pointer() {
        return {transform: `rotate(${42 + this.speed * this.measureSpace / this.measure.unit}deg)`};
      },
    },
  }
</script>

<style lang='stylus'>
  @import '~styles/main'

  .gauge
    box-sizing border-box
    gauge-radius = 6.5em
    @extend .flex, .center
    margin .25em
    width (gauge-radius * 2)
    height @width
    color #fff
    background color
    border-radius 50%
    border .4em solid
    box-shadow 0 .1em .5em .2em rgba(#000, .1)
    overflow hidden
    .dot
      @extend .flex, .center
      width .5em
      height @width
      background #fff
      border-radius 50%
      position relative
      .pointer
        z-index 1
        background color + 20%
        position absolute
        border-radius .5em
        align-self flex-start
        border .1em solid
        box-shadow .1em 0 .1em .1em rgba(#333, .2)
        height gauge-radius - 1.5em; width .25em
        margin-left -.15em; margin-top 50%
        transform-origin top; transform rotate(45deg)
      .measureWrapper
        margin-left -.075em
        height gauge-radius
        position absolute
        width .15em
        bottom 50%
        .unit
          position absolute
          width 100%
          height 100%
          transform-origin bottom; transform rotate(-135deg)
          p
            z-index 1
            top .33em
            left -.5em
            margin 0
            position relative
            color #fff
            font-weight 600
            transform rotate(-2.5deg)
</style>
