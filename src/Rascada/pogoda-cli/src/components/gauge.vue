<template lang='jade'>

.gauge
  .screen
    h1 {{ value | round }}
  .dot
    .pointer(:style='pointer')
    .measureWrapper
      .unit(v-for='n in measure.range' v-bind:style='unitPosition(n)')
        p(:style='unitValuePosition(n)') {{ unitValue(n) }}

</template>

<script>
  import round from 'vue/filter/round';

  function defaultProps(merge) {
    let defaultProps = {
      range: 12,
      from: 0,
      unit: 3,
    };

    return Object.assign({}, defaultProps, merge);
  }

  export default {
    props: {
      value: Number,
      measure: {
        default: defaultProps,
        coerce: function(val) {
          return defaultProps(val);
        },
      },
    },

    filters: {
      round,
    },

    methods: {
      unitValue(n) {
        return n * this.measure.unit + this.measure.from;
      },

      unitValuePosition(n) {
        let shift = { x: 0, y: 0 };
        let rotation = 0;

        let val = this.unitValue(n);
        switch (true) {
          case val >= 1000:
            shift.x = -.8;
            shift.y = .1;
            rotation = -5;
            break;
          case val >= 100:
            shift.x = -.5;
            break;
        }

        return {transform: `translate(${shift.x}em, ${shift.y}em) rotate(${rotation}deg)`};
      },

      unitPosition(n) {
        let rotation = -135 + n * this.measureSpace;

        return {transform: `rotate(${rotation}deg)`};
      },
    },

    computed: {
      measureSpace() {
        return 270 / (this.measure.range - 1);
      },

      pointer() {
        return {transform: `rotate(${42 + (this.value - this.measure.from) * this.measureSpace / this.measure.unit}deg)`};
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
    position relative
    margin .25em
    width (gauge-radius * 2)
    height @width

    color color
    background #fff
    border-radius 50%
    border 1.5em solid color
    box-shadow 0 .1em .5em .2em rgba(#000, .1)
    .screen
      @extend .flex, .jcenter, .aend
      position absolute
      left 0; top 0
      width 100%
      height 100%
    .dot
      @extend .flex, .center
      width .5em
      height @width
      background color
      border-radius 50%
      border .1em solid color + 20%
      box-shadow 0 .1em .1em rgba(#333, .2)
      position relative
      .pointer
        background color
        position absolute
        border-radius .5em
        align-self flex-start
        border .1em solid color + 20%
        box-shadow .1em 0 .1em rgba(#333, .2)
        height gauge-radius - 1.5em; width .25em
        margin-left -.2em; margin-top 50%
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
            top .1em
            left -.5em
            margin 0
            position relative
            color #fff
            font-weight 600
</style>
