<template lang="jade">

span {{updateInfo}}

</template>

<script>
import ms from 'pretty-ms';

export default {
  data() {
    return {
      updateInfo: 'aktualizowanie',
    };
  },

  ready() {
    this.$parent.$parent.api.basic
      .on('nextUpdate', time => this.nextUpdate(time));
  },

  methods: {
    nextUpdate(time) {
      if (time) {
        this.thread ? clearTimeout(this.thread) : null;

        this.thread = setInterval(_ => this.parse(--time), 1000);
      }
      return time;
    },

    parse(time) {
      this.updateInfo = time > 0
        ? `aktualizacja za ${ ms(time * 1000) }`
        : `aktualizowanie w trakcie ${time ? `(${ms(-time * 1000)})` : ''}`;
    }
  },
}
</script>
