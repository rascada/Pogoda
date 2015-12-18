<template lang='jade'>

nav( v-show='visible' )
  -for(var i = 10; i--;)
    button menu #{i}

</template>

<script>
  export default {
    props: {
      visible: true
    }
  }
</script>

<style lang='stylus' scoped>
@import '~styles/main'

nav
  background #eee

  padding .5em
  margin .5em
  margin-top -.5em

  button
    margin 0 .5em
</style>
