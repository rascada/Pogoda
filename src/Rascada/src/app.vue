<style lang="stylus">
@import url("http://fonts.googleapis.com/css?family=Rajdhani:400,600&amp;subset=latin,latin-ext");

body
	margin 1em 1.5em
	overflow-x hidden
	background #539DC2
	font-family 'Rajdhani', bold, sans-serif
  
</style>

<template lang="jade">
termometer
</template>

<script>
import termometer from './components/termometer.vue'

export default {
  data () {
    return {

    }
  },
  components: {
    termometer
  }
}
</script>
