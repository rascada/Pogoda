<template lang='jade'>
  header
    h1 {{ name }}
</template>

<script>
  export default {
    data(){
      return {
        name: 'Wstaw nazwe'
      }
    },
    props: ['name']
  }
</script>

<style lang='stylus'>
  header
    background #eee

    margin .5em
    padding .5em 1em
</style>
