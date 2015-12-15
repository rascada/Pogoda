<style lang="stylus">
	@import url("http://fonts.googleapis.com/css?family=Rajdhani:400,600&amp;subset=latin,latin-ext");
	@import "~styles/main"
	@import "~styles/flex"

	body
		margin 1em 1.5em
		overflow-x hidden
		background color
		font-family 'Rajdhani', bold, sans-serif
		main
			display flex

</style>

<template lang="jade">

navigationbar(name='Pogoda Skałągi')
main
	termometer

</template>

<script>
	import termometer from './components/termometer.vue'
	import navigationbar from './components/navigationBar.vue'

	export default {
	  components: {
	    termometer,
			navigationbar
	  }
	}
</script>
