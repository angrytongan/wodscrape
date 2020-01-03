#!/bin/bash
#
# Generate source php file from .csv of
# <title>,<url>
#
# Generated files will be invalid as selector won't match.

set -e

PROG=`basename $0`

CSV=${1:-''}
SOURCES_DIR=${2:-'../sources/'}

if [ -z "${CSV}" ]; then
    echo "usage: ${PROG} <csv>"
    exit 1
fi

if [ ! -d $SOURCES_DIR ]; then
    echo "${PROG}: can't find ${SOURCES_DIR}"
    exit 1
fi

while IFS=, read -r TITLE URL
do
    FILENAME="${SOURCES_DIR}"$(echo $TITLE | sed -e "s/ /-/g")".php"

    if [ -f $FILENAME ]; then
        echo "${PROG}: ${FILENAME} already exists; skipping"
    else
        #echo "Creating ${FILENAME}"
        cat source_template.php | sed -e "s/%title%/${TITLE}/" -e "s#%url%#${URL}#" > $FILENAME
        chmod +x $FILENAME
    fi
done < $CSV
