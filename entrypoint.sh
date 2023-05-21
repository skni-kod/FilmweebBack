#!/bin/sh
php artisan && \
php artisan config:clear && \
php artisan config:cache && \
php artisan optimize && \
php-fpm & /usr/sbin/nginx -g 'daemon off;'
