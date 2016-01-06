<template lang='jade'>
  .gauge
    .dot
    .pointer


</template>

<script>
  export default {
    props: {
      speed: Number,
    }
  }
</script>

<style lang='stylus'>
  @import '~styles/main'

  .gauge
    @extend .flex, .center
    margin .25em
    width 13em
    height @width
    color color
    border-radius 50%
    border .1em solid
    .dot
      width .5em
      height @width
      background color
      border-radius 50%
    .pointer
      align-self flex-start
      position relative
      background color
      left -.35em; top 50%
      height 40%; width .2em
      transform rotate(45deg)
      transform-origin top
</style>
