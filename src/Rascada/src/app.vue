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
			@extend .center
			justify-content space-around

</style>

<template lang="jade">

navigationbar(name='Pogoda Skałągi')
main
	termometer
	compass
	vial

</template>

<script>
	import termometer from './components/termometer.vue'
	import navigationbar from './components/navigationBar.vue'
	import compass from './components/compass.vue'
	import vial from './components/vial.vue'
	let aja = require('aja');

	export default {
	  components: {
	    termometer,
			navigationbar,
			compass,
			vial
	  },

		data(){
			return {
				api: {
					basic: {}
				}
			}
		},

		ready(){
			this.basic().on('success', api => this.api.basic = api ).go();
		},

		methods: {
			basic(firstGetParam, ...getParams){
				let params = firstGetParam ? `?${firstGetParam}` : '';

				if(getParams)
					getParams.forEach( param => params += `&${param}`);

				return aja().url(`//pogoda/app_dev.php/api/basic.json${params}`)
					.type('jsonp').jsonPadding('jsonp');
			},

			initApi(api){
				let requests = this.api.basic.request;

				this.api.basic = api;
				requests.forEach( req => req(api) );
			}
		}
	}
</script>
