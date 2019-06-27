#!/usr/bin/env bash
SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"
composer install --no-dev --working-dir=$SCRIPT_DIR --no-interaction --no-progress --no-suggest
$SCRIPT_DIR/migrate-database
php ./cli/teach.php regenerateTDBM