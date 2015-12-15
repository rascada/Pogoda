<template lang='jade'>
  .compass
    .arrow
</template>

<style lang='stylus'>
  @import "~styles/main"
  @import "~styles/flex"

  .compass
    @extend .blockShadow, .center
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
