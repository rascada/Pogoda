#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

node /usr/local/lib/node_modules/jade/bin/jade.js $DIR/../src/Rascada/views/*.jade -o $DIR/../web
node /usr/local/lib/node_modules/stylus/bin/stylus $DIR/../src/Rascada/styl -o $DIR/../web/css
node /usr/local/lib/node_modules/babel-cli/bin/babel.js $DIR/../src/Rascada/script --out-dir $DIR/../web/js
