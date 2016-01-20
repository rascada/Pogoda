'use strict';

export default Basic;

import aja from 'aja';
import eventEmiter from 'eventemitter2';

/** Class representing basic api */
class Basic extends eventEmiter {

  /**
   * @param {string} [url] Url to pogoda api.
   */

  init(source) {
    this.source = source;
    this.handleRequest();
    this.emit('init');
  }

  /**
   * Send request to api.
   * @param {number} [delay] Delay request.
   */

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


  /**
   * @param {object} [api] emit api.
   */

  handleRequest(api) {
    if (api) {
      this.emit('updated', api);
      this.emit('nextUpdate', api.time.next.value);

      this.sendRequest(api.time.next.value * 1000);
    } else if (!this.time) this.sendRequest();
  }
};
