'use strict';

let webpack = require('webpack');

module.exports = {
  entry: './src/main.js',

  output: {
    path: '../../../web/js',
    publicPath: '/js/',
    filename: 'build.js',
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
        exclude: /node_modules/,
      },
    ],
  },

  babel: {
    presets: ['es2015', 'stage-0'],
    plugins: ['transform-runtime'],
  },
};
