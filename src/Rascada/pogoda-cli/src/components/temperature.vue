<template lang='jade'>

paper-material.temperature
  h1 Temperatura
  termometer(:degrees='current')

  select(v-model='choice')
    option aktualna
    option(selected) odczuwalna

</template>

<script>

import termometer from './termometer';

export default {
  components: {
    termometer,
  },

  data() {
    return {
      choice: '',
      temperature: {
        actual: 0,
        real: 0,
      },
    };
  },

  methods: {
    apiConnect(api) {
      let temperature = api.temperature;

      Object.assign(this.temperature, {
        actual: temperature.current.value,
        real: temperature.real.value,
      });
    },
  },

  computed: {
    current() {
      switch (this.choice) {
        case 'aktualna':
          return this.temperature.actual;
        default:
          return this.temperature.real;
      };
    },
  },

  ready() {
    this.$parent.api.basic.on('updated', this.apiConnect);
  },
};

</script>

<style lang='stylus'>
@import '~flexstyl/index'
@import "~styles/main"
@import "~styles/section"

.temperature
  @extend .section, .flex, .fcolumn, .acenter
  overflow hidden

  h1
    margin 0

</style>
