'use strict';

let aja = require('aja');
let ee = require('eventemitter2');

module.exports = class Basic extends ee{
  init(source) {
    this.source = source;
    this.sendRequest();
    this.emit('init');
  }

  prepareRequest(firstGetParam, ...getParams) {
    let params = firstGetParam ? `?${firstGetParam}` : '';

    if (getParams)
      getParams.forEach(param => params += `&${param}`);

    return aja().url(`${this.source}/basic.json${params}`);
  }

  sendRequest(api) {
    let makeRequest = delay =>
      setTimeout(_=> this.prepareRequest().on('success', this.sendRequest.bind(this)).go(), delay);

    if (api) {
      Object.assign(this, api);
      this.emit('updated');
      makeRequest(api.time.next.value * 1000);
    } else if (!this.time) makeRequest();
  }
};
