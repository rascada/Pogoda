<template lang='jade'>

.compassWraper
  h1 {{ title }}
  .compass
    .arrow(:style='arrowDirection')

</template>

<script>

  export default {
    props: {
      title: '',
      direction: null,
    },

    computed: {
      arrowDirection() {
        return {
          transform: `rotate(${(this.direction + 45)}deg)`,
          borderRadius: !this.direction ? '50%' : null,
        };
      },
    },
  }

</script>

<style lang='stylus'>
  @import "~styles/main"
  @import "~styles/flex"

  .compassWraper
    text-align center

  .compass
    @extend .blockShadow, .flex, .center
    margin .5em
    width 13em
    height @width
    background color
    position relative
    border-radius 50%
    .arrow
      width 80%
      height 80%
      background #fff
      border-radius 0 50% 50% 50%
      border .4em solid
      transform rotate(45deg)
</style>
