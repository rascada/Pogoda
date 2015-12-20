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
      flex-wrap wrap
      justify-content space-around
</style>

<template lang="jade">

navbar(name='Pogoda Skałągi')
main
  vial
  wind-section
  termometer

</template>

<script>
  import windSection from './components/wind-section.vue'
  import termometer from './components/termometer.vue'
  import navbar from './components/navbar.vue'
  import vial from './components/vial.vue'
	let aja = require('aja');

	export default {
	  components: {
			windSection,
	    termometer,
			navbar,
			vial,
	  },

		data(){
			return {
        env: process.env.NODE_ENV,
				api: {
          source: 'https://pi.syntax-shell.me/api',
					basic: {
						request: []
					}
				}
			}
		},

		ready(){
      if (this.env == 'production')
        this.api.source = '/api';

			this.initApi();
		},

		methods: {
			basic(firstGetParam, ...getParams){
				let params = firstGetParam ? `?${firstGetParam}` : '';

				if(getParams)
					getParams.forEach( param => params += `&${param}`);

				return aja().url(`${this.api.source}/basic.json${params}`);
			},

			initApi(api){
				let requests = this.api.basic.request;
				let makeRequest = delay =>
					setTimeout(_=> this.basic().on('success', this.initApi).go(), delay);

				if (api) {
					this.api.basic = api;
					makeRequest(api.time.next.value * 1000)

					if (requests)
						requests.forEach( req => req(api) );

				}else if (requests) makeRequest();
		}
	}
}
</script>
