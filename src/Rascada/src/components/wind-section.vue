<template lang='jade'>
  compass(:direction='direction')
</template>

<script>
  import compass from './compass.vue'

  export default {
    components: {
      compass
    },

    data(){
      return {
        wind: {
          gust: 0,
          actual: 0
        }
      }
    },

    ready(){
      this.$parent.api.basic.request.push(api => {
        this.wind.actual = api.wind.currentDir.value;
          this.wind.gust = api.wind.gustDir.value;
      });
    }
  }
</script>
