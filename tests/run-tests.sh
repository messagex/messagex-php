#!/bin/bash

PHPUNIT=./vendor/bin/phpunit
TEST_PATH=$1
TEST_FILTER=$2

echo "PATH: " $TEST_PATH

php -S localhost:8889 tests/router.php >> /tmp/phpd.log 2>&1 &
PROCESS_ID=$!

echo PHP server process ID is $PROCESS_ID

$PHPUNIT $TEST_PATH $TEST_FILTER --coverage-html html tests/

kill -9 $PROCESS_ID
