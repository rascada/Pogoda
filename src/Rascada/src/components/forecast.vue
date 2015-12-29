<template lang='jade'>
  .forecast
    .peroid(v-for='forecast in week' v-show='focused == $index')
      .title
        img(:src='forecast.icon_url')
        h1 {{ forecast.title }}
      p {{ forecast.fcttext_metric }}
    .update(v-show='update')
      span prognoza
      span dane z {{ update }}
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
      aja().url(`${this.$parent.api.source}/wu/forecast.json`)
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

    .title
      display flex
      justify-content space-around
      align-items center

    .update
      width 100%

      border-top .1em solid #444
      padding-top .5em

      display flex
      justify-content space-between

      span
        margin 0 .25em
</style>
