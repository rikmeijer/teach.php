#!/usr/bin/env bash
SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"
echo "Installing dependencies..."
/usr/bin/composer install --no-dev --working-dir="$SCRIPT_DIR" --no-interaction --no-progress --no-plugins

echo "Running migrations..."
./migrate-database.sh

echo "Regenerating TDBM..."
php cli/teach.php regenerateTDBM