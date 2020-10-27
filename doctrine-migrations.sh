#!/bin/sh
SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"
./vendor/bin/doctrine-migrations "$@" --configuration "${SCRIPT_DIR}/migrations.xml"
