'use strict';

import aja from 'aja';
import eventEmiter from 'eventemitter2';

export default class Basic extends eventEmiter{
  init(source) {
    this.source = source;
    this.handleRequest();
    this.emit('init');
  }

  sendRequest(delay) {
    setTimeout(_=>
      this.prepareRequest()
        .on('success', this.handleRequest.bind(this))
        .go(), delay);
  }

  prepareRequest(firstGetParam, ...getParams) {
    let params = firstGetParam ? `?${firstGetParam}` : '';

    if (getParams)
      getParams.forEach(param => params += `&${param}`);

    return aja().url(`${this.source}/basic.json${params}`);
  }

  handleRequest(api) {
    if (api) {
      this.emit('updated', api);
      this.emit('nextUpdate', api.time.next.value);

      this.sendRequest(api.time.next.value * 1000);
    } else if (!this.time) this.sendRequest();
  }
};
