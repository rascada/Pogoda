<template lang='jade'>

.gauge
  .screen
    h3 {{ value | round 2 }} {{ unitName }}
  .dot
    .pointer(:style='pointer')
    .measureWrapper
      .unit(v-for='n in measure.range' v-bind:style='unitPosition(n)')
        p(:style='unitValuePosition(n)') {{ unitValue(n) }}

</template>

<style lang='stylus' src='./style/gauge'></style>

<script>
  import round from 'vue-round-filter';
  import defaultProps from './model/gauge';
  import dynamic from 'dynamics.js';

  export default {
    props: {
      value: Number,
      unitName: '',
      measure: {
        default: defaultProps,
        coerce: function(val) {
          return defaultProps(val);
        },
      },
    },

    data() {
      return {
        animation: false,
      };
    },

    ready() {
      this.$watch('value', this.animate);
    },

    filters: {
      round,
    },

    methods: {
      unitValue(n) {
        return n * this.measure.unit + this.measure.from;
      },

      animate(value, prev) {
        if (!this.animation) {
          this.$dispatch('animate', this.animation = true);
          this.value = prev;

          dynamic.animate(this, {
            value,
          }, {
            type: dynamic.spring,
            duration: 2000,
            friction: 300,
            delay: 250,
            complete: _ => this.$dispatch('animate', this.animation = false),
          });
        }
      },

      unitValuePosition(n) {
        let shift = { x: 0, y: 0 };
        let rotation = 0;

        let val = this.unitValue(n);
        switch (true) {
          case val >= 1000:
            shift.x = -.8;
            shift.y = .1;
            rotation = -5;
            break;
          case val >= 100:
            shift.x = -.5;
            break;
          case val >= 10:
            shift.x = -.25;
            break;
        }

        return { transform: `translate(${shift.x}em, ${shift.y}em) rotate(${rotation}deg)` };
      },

      unitPosition(n) {
        let rotation = -135 + n * this.measureSpace;

        return { transform: `rotate(${rotation}deg)` };
      },
    },

    computed: {
      measureSpace() {
        return 270 / (this.measure.range - 1);
      },

      pointer() {
        return { transform: `rotate(${41 + (this.value - this.measure.from) * this.measureSpace / this.measure.unit}deg)` };
      },
    },
  };

</script>
