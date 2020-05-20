#!/bin/bash

PHPUNIT=./vendor/bin/phpunit

php -S localhost:8889 tests/router.php > /tmp/phpd.log 2>&1 &
PROCESS_ID=$!

echo Process ID is $PROCESS_ID

kill -9 $PROCESS_ID
