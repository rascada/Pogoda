<template lang='jade'>
  .compass
    .arrow(:style='{ transform: "rotate(" + (direction.value + 45) + direction.units + ")" }')
</template>

<script>

  export default {
    data(){
      return {
        direction: 0
      }
    },

    ready(){
      this.$parent.api.basic.request.push(api => {
        this.direction = api.wind.currentDir;
      });
    }
  }

</script>

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
