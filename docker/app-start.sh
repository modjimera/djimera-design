#!/usr/bin/env sh
set -e

php artisan package:discover --ansi
php artisan storage:link || true
php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan view:cache

exec php -S 0.0.0.0:${PORT:-8000} -t public public/router.php
