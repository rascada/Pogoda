<template lang='jade'>

.compass
  .arrowWrapper
    .arrow(:style='arrowDirection')
    .screen
      slot
        h1(v-show='direction') {{ direction | round 2 }}°
      slot(name='screen')

</template>

<script>
  import round from 'vue-round-filter';

  export default {
    props: {
      title: '',
      direction: null,
    },

    filters: {
      round,
    },

    computed: {
      arrowDirection() {
        return {
          transform: `rotate(${this.direction + 45}deg)`,
          borderRadius: this.direction == null ? '50%' : null,
        };
      },
    },
  };

</script>

<style lang='stylus'>
  @import "~styles/main"
  @import "~flexstyl/index"

  .compass
    @extend .blockShadow, .flex, .center
    margin 1.1em
    width 13em
    height @width
    background color
    position relative
    border-radius 50%
    .arrowWrapper
      width 85%
      height 85%
      position relative

      .arrow
        box-sizing border-box

        width 100%
        height 100%

        background #fff
        position relative
        border .4em solid
        transform rotate(45deg)
        border-radius 0 50% 50% 50%

      .screen
        @extend .flex, .center, .fcolumn
        position absolute

        arrow = -20%
        top -(arrow / 2)
        left -(arrow / 2)
        width 100% + arrow
        height 100% + arrow

</style>
