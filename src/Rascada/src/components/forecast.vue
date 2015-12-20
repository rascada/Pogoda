<template lang='jade'>
  .forecast
    h1 prognoza
    span {{ update }}
</template>

<script>
  let aja = require('aja');

  export default {
    data(){
      return {
        update: false,
        week: false,
        simple: false,
      }
    },

</script>

<style lang='stylus'>
  @import '~styles/main'

  .forecast
    @extend .blockShadow, .sect
</style>
