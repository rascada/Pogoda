#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

node /usr/local/lib/node_modules/webpack/bin/webpack.js $DIR/../src/Rascada
