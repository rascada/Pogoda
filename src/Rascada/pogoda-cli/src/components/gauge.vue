<template lang='jade'>
  .gauge
    h1 {{ speed }}
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
</style>
