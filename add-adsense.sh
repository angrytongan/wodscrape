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

sed -i.bak -f adsense-index.html.sed ${DESTDIR}/index.html

rm -f ${DESTDIR}/index.html.bak
