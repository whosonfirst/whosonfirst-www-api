#!/bin/sh

WHOAMI=`python -c 'import os, sys; print os.path.realpath(sys.argv[1])' $0`

PARENT=`dirname $WHOAMI`
PROJECT=`dirname $PARENT`
SCHEMA="${PROJECT}/elasticsearch/schema"

cat ${SCHEMA}/mappings.whosonfirst.json | curl -XPUT http://localhost:9200/whosonfirst_current -d @-
curl -XPOST http://localhost:9200/_aliases -d '{ "actions": [ { "add": { "alias": "whosonfirst", "index": "whosonfirst_current" }} ] }'

exit 0
