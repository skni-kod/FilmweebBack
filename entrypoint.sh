#!/bin/sh
php artisan config:clear && \
php artisan config:cache && \
php artisan optimize && \
php-fpm & \
/usr/sbin/nginx -g 'daemon off;'& 

# Wait for any process to exit
wait -n

# Exit with status of process that exited first
exit $?