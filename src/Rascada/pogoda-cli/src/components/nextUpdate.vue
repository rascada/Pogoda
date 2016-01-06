<template lang="jade">
span aktualizacja za {{timeToUpdate}}s
</template>

<script>
export default {
  data() {
    return {
      timeToUpdate: 0,
    };
  },

  ready() {
    this.$parent.$parent.api.basic.on('nextUpdate', time => this.nextUpdate(time));
  },

  methods: {
    nextUpdate(time) {
      if (time){
        this.thread ? clearTimeout(this.thread) : null;
        this.thread = setInterval(_ => {
          this.timeToUpdate = --time;
        }, 1000);
      }
      return time;
    },
  },
}
</script>
