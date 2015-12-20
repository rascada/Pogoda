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

    ready(){
      aja().url(`https://pi.syntax-shell.me/api/wu/forecast.json`)
        .on('success', res => {
          let forecast = res.forecast;
          let week = forecast.txt_forecast;

          Object.assign(this, {
            update: week.date,
            week: week.forecastday,
            simple: forecast.simpleforecast.forecastday
          })
        })
        .go();
    }
  }
</script>

<style lang='stylus'>
  @import '~styles/main'

  .forecast
    @extend .blockShadow, .sect
</style>
