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
      @extend .flex, .center
      width .5em
      height @width
      background color
      border-radius 50%
      position relative
      .pointer
        align-self flex-start
        position absolute
        background color
        height 6em; width .25em
        margin-left -.15em; margin-top 50%
        border-radius .5em
        transform-origin top; transform rotate(45deg)
</style>
