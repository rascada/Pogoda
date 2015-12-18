<template lang='jade'>
  .navigationBar(@mouseover='navbar.visible = true' @mouseout='navbar.visible = false')
    header

      ul.sunLogo
        -for(var i = 3; i--;)
          li

      h1 {{ name }}
    menu(:visible='navbar.visible')
</template>

<script>
  import menu from './menu.vue'

  export default {
    components: {
      menu
    },

    props: {
      name: 'Wstaw nazwe'
    },

    data(){
      return {
        navbar: {
          visible: true
        }
      };
    }
  }
</script>

<style lang='stylus'>
  @import "~styles/main"
  sunWidth = 4em

  header
    display flex
    align-items center

    background #eee
    color color
    text-shadow .05em .05em (teal + 20%)
    @extend .blockShadow

    margin .5em
    padding .5em 1em

    .sunLogo
      width 1.5em
      height sunWidth
      margin 1em
      list-style none
      animation rotation 25s ease-in-out infinite
      li
        top 0
        left 0
        width sunWidth
        height sunWidth
        opacity 0.6
        position absolute
        background #fad335
        borderRound()
        &:nth-child(1)
          transform rotate(60deg)
        &:nth-child(2)
          transform rotate(30deg)
        &:nth-child(3)
          transform rotate(0deg)
        @keyframes rotation
          0%
            transform rotate(360deg)
</style>
