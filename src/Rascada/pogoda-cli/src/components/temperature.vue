<template lang='jade'>

.temperature
  h1 Temperatura
  termometer(:degrees='temperature')

  select
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
      temperature: 0,
    };
  },

  methods: {
    apiConnect(api) {
      this.temperature = api.temperature.current.value;
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
