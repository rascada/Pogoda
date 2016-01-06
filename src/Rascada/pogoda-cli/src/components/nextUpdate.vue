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
      setTimeout(_ => this.nextUpdate(--time), 1000);
      return this.timeToUpdate = time;
    },
  },
}
</script>
