<template lang="jade">
.barometer
  h2 ciśnienie
  h1 {{ pressure }}
  gauge(:start='960')
</template>

<script>
  import gauge from './gauge.vue'

  export default {
    components: {
      gauge,
    },

    data() {
      return {
        pressure: 960,
      };
    },

    ready() {
      this.$parent.api.basic.on('updated', api => {
        this.pressure = api.barometer.current.value;
      });
    }
  }
</script>

<style lang="stylus">
@import '~styles/section'

.barometer
  @extend .section

</style>
