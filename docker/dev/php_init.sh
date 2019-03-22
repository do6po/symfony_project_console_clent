#!/usr/bin/env bash

cp -n .env.example .env
cp -n .env.example .env.tests

chmod +x bin/console phpunit console

composer install --no-progress --prefer-dist

php bin/console cache:clear

sudo -s

exec php-fpm --nodaemonize
