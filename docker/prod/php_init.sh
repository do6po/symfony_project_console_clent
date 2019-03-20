#!/usr/bin/env bash

cd /app

chmod +x bin/console

composer install --no-progress --prefer-dist --working-dir=/app

php bin/console cache:clear

chmod 777 -R /app/var

exec php-fpm --nodaemonize
