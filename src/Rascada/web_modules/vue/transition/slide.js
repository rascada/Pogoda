'use strict';

function slide(el, value, done) {

  if (!this.rect) {
    el.style.height = null;
    this.rect = el.getBoundingClientRect().height;
  }

  value = typeof value != 'number' ? this.rect : value;

  dyn.stop(el);
  dyn.animate(el, {
    height: value,
  }, {
    duration: 700,
    complete: function() {
      if (done) done.call();
    },
  });
};

module.exports = {
  enter: function(el, done) {
    slide.call(this, el, null, done);
  },

  enterCancelled: function(el) {
    slide.call(this, el, 0);

  },

  leave: function(el, done) {
    slide.call(this, el, 0, done);
  },

  leaveCancelled: function(el) {
    slide.call(this, el, null);
  },
};
