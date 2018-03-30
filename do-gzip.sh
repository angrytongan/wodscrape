#!/bin/bash

PROG=`basename $0`

WEBROOT=${1:-''}

if [ -z ${WEBROOT} ]; then
    echo "usage: ${PROG} <webroot>"
    exit 1
fi

if [ ! -d ${WEBROOT} ]; then
    echo "${PROG}: can't find directory ${WEBROOT}"
    exit 1
fi

echo "gzipping html, css, js"
find ${WEBROOT} \( -name "*.html" -o -name "*.css" -o -name "*.js" \) \
    -exec gzip -n "{}" \; -exec /bin/mv "{}.gz" "{}" \;
