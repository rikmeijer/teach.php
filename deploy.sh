#!/usr/bin/env bash
SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"
git pull
$SCRIPT_DIR/install.sh