#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

jade $DIR/../src/Rascada/views/*.jade -o $DIR/../web
stylus $DIR/../src/Rascada/styl -o $DIR/../web/css
babel $DIR/../src/Rascada/script --out-dir $DIR/../web/js
