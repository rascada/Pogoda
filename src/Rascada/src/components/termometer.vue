<template lang='jade'>
#tempSect
	h1 Temperatura
	p Dziś temperatura wynosi: {{ degrees }}
	.thermometer
		.measure
			-for(var i=30;i--;)
				-if(i % 5 == 0 && i != 30)
					div.line.boldLine
						p #{i}
				-else
					.line
		.sensor
			#temperatureCurrentSensor.sensorVal(:style="{height: 13 + (degrees * 2.9) + '%'}")
				span#temperatureCurrent
				span

		.bottom
</template>

<script>
  export default {
    data () {
      return {
        degrees: 0
      }
    },
    methods:{
      updateTemperature(){
        let xhr = new XMLHttpRequest();

        xhr.open('get', '/api?temperature');
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.onload = e => {
          let res = JSON.parse(e.target.responseText);

          this.degrees = res.temperature.current.value;
          setTimeout(this.updateTemperature, res.time.next.value * 1000);
        };
        xhr.send();
      }
    },

    ready () {
      this.updateTemperature();
    },

    destroyed () {

    }
  }
</script>

<style lang='stylus'>
@import "~styles/main"
thermometerColor = #f42

#tempSect
  @extend .sect, .blockShadow

.thermometer
  width 4.5em
  height 24em
  display flex
  padding .5em
  padding-top 2em
  background #fff
  border-radius 4em
  margin-bottom 6em
  position relative
  justify-content center
  .bottom
    top 90%
    width 35%
    height 32%
    content ''
    background #fff
    position absolute
    border-radius 2em
    overflow hidden
    left 50% - (@width/2)
  &:after
    content ''
    position absolute
    top -1.9%
    left 56%
    width 110%
    height 135%
    z-index 3
    transform skew(25deg) rotate(25deg)
    background rgba(0,0,0,.1)
  .sensor
    z-index 2
    width 15%
    height 107.5%
    position relative
    borderRound()
    background #eee
    &:before
      top 97%
      width 150%
      height 18%
      content ''
      background thermometerColor
      position absolute
      border-radius 2em
      left 49.5% - (@width/2)
    .sensorVal
      position absolute
      bottom 0
      left 0
      width 100%
      height 70%
      background thermometerColor
      span
        position relative
        top -2.5%
        left 150%
  .measure
    position absolute
    height 85%
    width 20%
    z-index 2
    left 0
    display flex
    flex-flow column
    .line
      position relative
      background #444
      flex-grow 1
      margin-top .5em
      width 90%
    .boldLine
      width 150%
      p
        position absolute
        right 160%
        top -200%
        padding .25em
        margin 0
        background #fff
        &:after
          content ''
          width 100%
          height 100%
          background #fff
          transform rotate(45deg)
          top 0
          left 25%
          z-index -1
          position absolute
</style>
