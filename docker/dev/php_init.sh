#!/usr/bin/env bash

chmod +x bin/console phpunit console

composer install --no-progress --prefer-dist

php bin/console cache:clear

sudo -s

exec php-fpm --nodaemonize
