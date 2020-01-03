#!/bin/bash

set -e

PROG=`basename $0`

SOURCEDIR=${1:-''}
DESTDIR=${2:-''}

if [ -z "${SOURCEDIR}" -o -z "${DESTDIR}" ]; then
    echo "usage: ${PROG} <index file> <production directory>"
    exit 1
fi

if [ ! -d ${SOURCEDIR} ]; then
    echo "${PROG}: no directory ${SOURCEDIR}"
    exit 1
fi

if [ ! -d ${DESTDIR} ]; then
    echo "${PROG}: no directory ${DESTDIR}"
    exit 1
fi

> ${DESTDIR}/selector.js
for i in $SOURCEDIR/*.php; do
    echo "\""$(echo $i | sed -e "s/${SOURCEDIR}\///g" -e 's/\.php$//g' -e 's/-/ /g')"\"," >> ${DESTDIR}/selector.js
done
sed -i.bak -f fix-selector.sed ${DESTDIR}/app.js

BUILD_DATE=$(date)
sed -e "s/%build-date%/${BUILD_DATE}/" < ${SOURCEDIR}/index.html > ${DESTDIR}/index.html
sed -i.bak -e "s/%build-date%/${BUILD_DATE}/" ${DESTDIR}/app.js

rm -f ${DESTDIR}/selector.js
rm -f ${DESTDIR}/index.html.bak
rm -f ${DESTDIR}/app.js.bak
