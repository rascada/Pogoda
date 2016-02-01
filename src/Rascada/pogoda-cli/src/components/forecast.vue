<template lang='jade'>

paper-material.forecast
  div(v-if='populated')
    .peroid(v-for='forecast in week' v-show='focused == $index')
      .icons
        .icon(v-for='forecast in week' @click="focused = $index")
          img(:src='forecast.icon_url')
          paper-tooltip(position='top') {{ forecast.title | shortWeekTitle }}

      .title
        img(:src='forecast.icon_url')
        h1 {{ forecast.title | shortWeekTitle }}

      p {{ forecast.fcttext_metric }}

    .arrows
      paper-button(@transitionend='changeForecast(-1)' v-show='near.yesterday').
        {{ near.yesterday.title | shortWeekTitle }}

      paper-button(@transitionend='changeForecast(1)' v-show='near.tomorrow').
        {{ near.tomorrow.title | shortWeekTitle }}

    .update(v-show='update')
      span.name prognoza
      span dane z {{ update }}

  .spinner(v-else)
    paper-spinner(:active='!populated')

</template>

<style lang='stylus' src='./style/forecast'></style>

<script>
  let aja = require('aja');

  export default {
    data() {
      return {
        focused: 0,
        week: false,
        update: false,
        simple: false,
        populated: false,
        ripple: false,
      };
    },

    methods: {
      changeForecast(howMuch) {
        if (this.ripple)
          this.focused += howMuch;

        this.ripple = !this.ripple;
      }
    },

    filters: {
      shortWeekTitle: function(value = '') {
        return value.replace('wieczór i', '');
      },
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

    ready() {
      aja().url(`${this.$parent.api.source}/wu/forecast.json`)
        .on('success', res => {
          let forecast = res.forecast;
          let week = forecast.txt_forecast;

          this.populated = true;

          Object.assign(this, {
            update: week.date,
            week: week.forecastday,
            simple: forecast.simpleforecast.forecastday,
          });
        })
        .go();
    },
  };

</script>
