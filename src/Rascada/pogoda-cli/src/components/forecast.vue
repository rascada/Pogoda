<template lang='jade'>

.forecast
  .peroid(v-for='forecast in week' v-show='focused == $index')
    .title
      img(:src='forecast.icon_url')
      h1 {{ forecast.title | shortWeekTitle }}

    p {{ forecast.fcttext_metric }}

  .arrows
    button(@click='focused--' v-show='near.yesterday').
      {{ near.yesterday.title | shortWeekTitle }}

    button(@click='focused++' v-show='near.tomorrow').
      {{ near.tomorrow.title | shortWeekTitle }}

  .update(v-show='update')
    span.name prognoza
    span dane z {{ update }}

  .icons
    .icon(v-for='forecast in week' @click="focused = $index")
      img(:src='forecast.icon_url')

</template>

<style lang='stylus' src='./style/forecast'></style>

<script>
  let aja = require('aja');

  export default {
    data() {
      return {
        focused: 0,
        update: false,
        week: false,
        simple: false,
      };
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
