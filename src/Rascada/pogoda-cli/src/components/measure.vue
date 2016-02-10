<template lang='jade'>

.measureDot
  .measureWrapper
    .unit(v-for='n in options.range' v-bind:style='unitPosition(-135, n)')
      p(:style='unitValuePosition(n)') {{ unitValue(n) }}

</template>

<script>

export default {
  props: {
    options: {},
  },

  methods: {
    unitValue(n) {
      return n * this.options.unit + this.options.from;
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
        case val >= 10:
          shift.x = -.25;
          break;
      }

      return { transform: `translate(${shift.x}em, ${shift.y}em) rotate(${rotation}deg)` };
    },

    unitPosition(start, n) {
      let rotation = start + n * this.measureSpace;

      return { transform: `rotate(${rotation}deg)` };
    },
  },

  computed: {
    measureSpace() {
      return 270 / (this.options.range - 1);
    },
  },
};

</script>

<style lang='stylus'>
@import '~flexstyl/index'

.measureDot
  @extend .flex, .center
  width 100%
  height 100%
  .measureWrapper
    top 0
    bottom 50%
    height 50%
    width .15em
    position absolute
    margin-left -.075em
    .unit
      width 100%
      height 100%
      position absolute
      transform-origin bottom; transform rotate(-135deg)
      p
        position relative
        margin 0
        top .1em
        left -.5em
        z-index 1

        color #fff
        font-weight 600

</style>
