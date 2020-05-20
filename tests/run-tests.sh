#!/bin/bash

PHPUNIT=./vendor/bin/phpunit

php -S localhost:8889 tests/router.php >> /tmp/phpd.log 2>&1 &
PROCESS_ID=$!

echo PHP server process ID is $PROCESS_ID

$PHPUNIT --coverage-html html tests/ $1 $2

kill -9 $PROCESS_ID
