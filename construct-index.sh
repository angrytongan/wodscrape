#!/bin/bash

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

> ${DESTDIR}/selector.html
for i in $SOURCEDIR/*.php; do
    echo "<option>"$(echo $i | sed -e "s/${SOURCEDIR}\///g" -e 's/\.php$//g' -e 's/-/ /g')"</option>" >> ${DESTDIR}/selector.html
done

BUILD_DATE=$(date)

sed -e "s/%build-date%/${BUILD_DATE}/" < ${SOURCEDIR}/index.html > ${DESTDIR}/index.html

sed -i.bak -f fix-selector.sed ${DESTDIR}/index.html

rm -f ${DESTDIR}/selector.html
rm -f ${DESTDIR}/index.html.bak
rm -f ${DESTDIR}/app.js.bak
