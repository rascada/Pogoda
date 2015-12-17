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
        direction: 0
      }
    },

    ready(){
      this.$parent.api.basic.request.push(api => {
        this.direction = api.wind.currentDir.value;
      });
    }
  }
</script>
