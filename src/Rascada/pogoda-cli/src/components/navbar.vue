<template lang='jade'>

paper-material.navbar(@mouseover='menu.visible = true' @mouseout='menu.visible = false')
  header

    ul.sunLogo
      -for(var i = 3; i--;)
        li

    h1 {{ name }}
    next-update
    span pogoda2
  menu(:visible='menu.visible' v-bind:buttons='buttons')
  paper-progress(:indeterminate='updateInProgress')

</template>

<script>
  import menu from './navbar/menu';
  import nextUpdate from './navbar/nextUpdate';

  export default {
    components: {
      nextUpdate,
      menu,
    },

    props: {
      name: 'Wstaw nazwe',
      buttons: [],
    },

    data() {
      return {
        updateInProgress: true,
        menu: {
          visible: true,
        },
      };
    },

    ready() {
      this.$parent.api.basic
        .on('nextUpdate', time => {
          this.updateInProgress = false;
          setTimeout(_ => this.updateInProgress = true, time * 1000);
        });
    },
  };

</script>

<style lang='stylus'>
  @import "~styles/main"
  @import "~flexstyl/index"
  sunWidth = 4em

  .navbar
    margin .5em

  paper-progress
    width 100%

  header
    @extend .flex, .w-around, .acenter

    background #eee
    color color
    text-shadow .05em .05em (teal + 20%)

    padding .5em 1em

    > span
      margin-left auto
      align-self flex-end
      font-weight 600

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
