<template lang='jade'>
  .forecast
    .peroid(v-for='forecast in week' v-show='focused == $index')
      h1 {{ forecast.title }}
      p {{ forecast.fcttext_metric }}
    span.update {{ update }}
</template>

<script>
  let aja = require('aja');

  export default {
    data(){
      return {
        focused: 0,
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
    text-align center
    max-width 15em
    .update
      align-self flex-end
</style>
