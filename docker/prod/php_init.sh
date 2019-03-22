#!/usr/bin/env bash

cp -n .env.example .env

chmod +x bin/console

composer install --no-progress --prefer-dist --working-dir=/app

php bin/console cache:clear

chmod 777 -R /app/var

exec php-fpm --nodaemonize
