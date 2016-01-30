'use strict';

import aja from 'aja';
import eventEmiter from 'eventemitter2';

/** Class representing basic api */
class Basic extends eventEmiter {

/**
  * @param {String} [url] Url to pogoda api.
  * @fires Basic#init
  */

  init(source) {
    this.source = source;
    this.handleRequest();

    /**
      * Basic initialized
      * @event Basic#init
      */
    this.emit('init');
  }

/**
  * Send request to api.
  * @param {Number} [delay] Delay request.
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
  * @param {Object} [api] emit api.
  * @fires Basic#updated
  * @fires Basic#nextUpdate
  */

  handleRequest(api) {
    if (api) {
      /**
        * api was updated
        * @event Basic#updated
        * @param {Object} basic api
        */
      this.emit('updated', api);

      /**
        * Time to next update
        * @event Basic#nextUpdate
        * @param {Number} time to next update.
        */
      this.emit('nextUpdate', api.time.next.value);

      this.sendRequest(api.time.next.value * 1000);
    } else if (!this.time) this.sendRequest();
  }
};

export default Basic;
