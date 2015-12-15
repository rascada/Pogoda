<template lang='jade'>
  header
    h1 {{ name }}
</template>

<script>
  export default {
    props: {
      name: 'Wstaw nazwe'
    }
  }
</script>

<style lang='stylus'>
  header
    background #eee

    margin .5em
    padding .5em 1em
</style>
