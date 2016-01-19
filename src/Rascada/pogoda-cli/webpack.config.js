'use strict';

let webpack = require('webpack');
let path = require('path');

module.exports = {
  entry: './src/weather.js',

  output: {
    path: '../../../web/js',
    publicPath: '/js/',
    filename: 'build.js',
  },

  resolve: {
    extensions: ['', '.js', '.vue'],
    alias: {
      src: path.resolve(__dirname, '../src'),
    },
  },

  module: {
    loaders: [
      {
        test: /\.vue$/,
        loader: 'vue',
      },
      {
        test: /\.js$/,
        loader: 'babel',
      },
    ],
  },

  babel: {
    presets: ['es2015', 'stage-0'],
    plugins: ['transform-runtime'],
  },
};
