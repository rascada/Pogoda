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
    .arrows
      button(@click='focused--' v-show='near.yesterday') {{ near.yesterday.title }}
      button(@click='focused++' v-show='near.tomorrow') {{ near.tomorrow.title }}
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

    computed: {
      near() {
        let focus = this.focused;
        let tomorrow = this.week[focus + 1];

        return {
          tomorrow: tomorrow ?
            tomorrow : false,

          yesterday: focus > 0 ?
            this.week[focus - 1] : false,
        };
      },
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
    },
  }
</script>

<style lang='stylus'>
  @import '~styles/flex'
  @import '~styles/main'
  @import '~styles/ui'

  .forecast
    @extends .blockShadow, .sect
    text-align center
    max-width 15em

    .title
      @extends .flex, .around, .acenter
      img
        transform translateY(-.2em)
        animation float 7.5s infinite ease-in-out
      h1
        padding-left .25em

    .update
      width 100%

      border-top .1em solid #444
      padding-top .5em

      @extends .flex, .between

      span
        margin 0 .25em

    .arrows
      width 100%
      margin .5em
      @extend .flex, .around
      button()
</style>
