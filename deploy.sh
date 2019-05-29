#!/bin/sh
SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"
git pull
composer install --no-dev --working-dir=$SCRIPT_DIR --no-interaction --no-progress --no-suggest
$SCRIPT_DIR/migrate-database
php ./cli/teach.php regenerateTDBM