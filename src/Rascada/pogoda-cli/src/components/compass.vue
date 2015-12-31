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
