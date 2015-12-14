<style lang="stylus">
	@import url("http://fonts.googleapis.com/css?family=Rajdhani:400,600&amp;subset=latin,latin-ext");

	body
		margin 1em 1.5em
		overflow-x hidden
		background #539DC2
		font-family 'Rajdhani', bold, sans-serif

</style>

<template lang="jade">

navigationbar(name='Pogoda Skałągi')
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
