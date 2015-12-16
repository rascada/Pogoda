module.exports = {
  entry: './src/main.js',
  output: {
    path: '../../web/js',
    publicPath: '/js/',
    filename: 'build.js'
  },
  module: {
    loaders: [
      {
        test: /\.vue$/,
        loader: 'vue'
      }
    ]
  }
}
