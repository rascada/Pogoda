#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
STAT="$DIR/../web/hooks_stat.html"

echo "<h3> Hook created at `date` </h3>" > $STAT
echo >> $STAT

echo "<h4>Git pull: " >> $STAT
GITPULL=$(cd $DIR/.. && git pull 2>&1)
echo $GITPULL >> $STAT
echo "</h4>" >> $STAT

echo "<h4>Front: " >> $STAT
FRONT=`$DIR/front.sh`
echo $FRONT | sed -e 's/rendered/<br>rendered/g' | \
sed -e 's/compiled/<br>compiled/g' | sed -e "s/\[//g" | \
sed -e "s/[0-9]m//g" | sed -e "s/[0-9]//g" >> $STAT
echo "</h4>" >> $STAT

echo "<h4>Cache: " >> $STAT
php $DIR/../app/console cache:clear --env=prod >> $STAT
echo "</h4>" >> $STAT
redis-cli set deploy_running false
