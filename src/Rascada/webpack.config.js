'use strict';

let webpack = require('webpack');

module.exports = {
  entry: './src/main.js',
  output: {
    path: '../../web/js',
    publicPath: '/js/',
    filename: 'build.js',
  },
  plugins: [
    new webpack.ProvidePlugin({
      dyn: 'dynamics.js',
    }),
  ],
  module: {
    loaders: [
      {
        test: /\.vue$/,
        loader: 'vue',
      },
    ],
  },
};
