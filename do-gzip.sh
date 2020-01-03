#!/bin/bash
#
# Compress parts of our distribution. This is required
# as AWS S3 doesn't provide compression on the run.

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

# Compress, but retain original name so everything
# sill works from the browser.
echo "gzipping html, css, js"
find ${WEBROOT} \( -name "*.html" -o -name "*.css" -o -name "*.js" \) \
    -exec gzip -n "{}" \; -exec /bin/mv "{}.gz" "{}" \;
