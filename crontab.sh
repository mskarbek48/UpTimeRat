#!/bin/bash

PROJECT_DIR=$(dirname "$(readlink -f "$0")")


PHP_BIN="/usr/bin/php"

CONSOLE="$PROJECT_DIR/bin/console"


cd "$PROJECT_DIR" || exit


$PHP_BIN $CONSOLE app:crontab


if [ $? -eq 0 ]; then
    echo "Crontab executed successfully."
else
    echo "Crontab execution failed."
    exit 1
fi

