'use strict';

let aja = require('aja');
let ee = require('eventemitter2');

module.exports = class Basic extends ee{
  init(source) {
    this.source = source;
    this.sendRequest();
    this.emit('init');
  }

  sendRequest(delay) {
    setTimeout(_=>
      this.prepareRequest()
        .go(), delay);
  prepareRequest(firstGetParam, ...getParams) {
    let params = firstGetParam ? `?${firstGetParam}` : '';

    if (getParams)
      getParams.forEach(param => params += `&${param}`);

    return aja().url(`${this.source}/basic.json${params}`);
  }

    if (api) {
  }
};
