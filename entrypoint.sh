#!/bin/sh
php artisan config:clear && \
php artisan config:cache && \
php artisan optimize && \
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
