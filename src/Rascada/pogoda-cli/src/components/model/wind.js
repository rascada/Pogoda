module.exports = function(o) {
  let model = {
    direction: null,
    speed: 0,
  };

  return !o ? model : Object.assign(model, o);
};
