#!/bin/sh
php artisan config:clear && \
php artisan config:cache && \
php artisan optimize && \
php-fpm -D && exec /usr/sbin/nginx -g 'user www-data www-data; daemon off;'

