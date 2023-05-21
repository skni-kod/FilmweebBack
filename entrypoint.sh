#!/bin/sh
php artisan config:clear && \
php artisan config:cache && \
php artisan optimize && \
php-fpm

status=$?
if [ $status -ne 0 ]; then
    # If the program failed, exit with status 1
    exit 1
fi
