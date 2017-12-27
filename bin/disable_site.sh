#!/bin/sh

PERL=`which perl`
PYTHON=`which python`

WHOAMI=`${PYTHON} -c 'import os, sys; print os.path.realpath(sys.argv[1])' $0`

BIN=`dirname $WHOAMI`
PROJECT=`dirname $BIN`

WWW="${PROJECT}/www"
INCLUDE="${WWW}/include"

for CONFIG in `ls -a ${INCLUDE}/config.php ${INCLUDE}/config_local*.php`
do
    ${PERL} -p -i -e "s/\['cfg'\]\['site_disabled'\]\s*=\s*[^;];/['cfg']['site_disabled'] = 1;/" ${CONFIG}
done

exit 0
