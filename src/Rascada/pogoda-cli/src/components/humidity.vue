<template lang="jade">
.humidity
  .sensor(:style='{ height: humidity + "%" }')
    .overlay
      h2 Wilgotność
      h1 {{ humidity | round 2 }}%
  h2 Wilgotność
  h1 {{ humidity | round 2 }}%
</template>

<script>
  import round from 'vue-round-filter';

  export default {
    data() {
      return {
        humidity: 0,
      };
    },

    filters: {
      round,
    },

    ready() {
      this.$parent.api.basic.on('updated',
        api => this.humidity = api.humidity.value
      );
    },
  };

</script>

<style lang="stylus">
@import '~styles/section'

.humidity
  @extend .section
  position relative
  h2
    margin 0
  h1
    margin 0

  .sensor
    width 100%
    height 70%
    bottom 0; left 0
    position absolute
    overflow hidden
    background rgba(color, .75)
    .overlay
      width 100%
      color #fff
      bottom .75em; left 0
      position absolute
</style>
