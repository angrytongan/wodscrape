#!/bin/bash

set -e

PROG=`basename $0`

DESTDIR=${1:-''}

if [ -z "${DESTDIR}" ]; then
    echo "usage: ${PROG} <production directory>"
    exit 1
fi

if [ ! -d ${SOURCEDIR} ]; then
    echo "${PROG}: no directory ${SOURCEDIR}"
    exit 1
fi

if [ ! -f ${DESTDIR}/index.html ]; then
    echo "${PROG}: no index file in ${DESTDIR}"
    exit 1
fi

sed -i.bak -f analytics-index.html.sed ${DESTDIR}/index.html
sed -i.bak -f analytics-app.js.sed ${DESTDIR}/app.js

rm -f ${DESTDIR}/index.html.bak
rm -f ${DESTDIR}/app.js.bak
