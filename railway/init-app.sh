#!/usr/bin/env bash
set -e

php artisan package:discover --ansi
php artisan storage:link || true
php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan view:cache
