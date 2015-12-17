<template lang='jade'>

.compassWraper
  h1 {{ title }}
  .compass
    .arrow(:style='{ transform: "rotate(" + (direction + 45) + "deg)" }')

</template>

<script>

  export default {
    props: {
      title: '',
      direction: 0
    },
  }

</script>

<style lang='stylus'>
  @import "~styles/main"
  @import "~styles/flex"

  .compassWraper
    text-align center

  .compass
    @extend .blockShadow, .center
    margin .5em
    width 13em
    height @width
    background #ddd
    position relative
    border-radius 50%
    .arrow
      width 80%
      height 80%
      background rgba(255,255,255,.75)
      border-radius 0 50% 50% 50%
      transform rotate(45deg)
</style>
