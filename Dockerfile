FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    postgresql-dev \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    nginx supervisor

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html
COPY ./nginx.conf /etc/nginx/http.d/default.conf
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ENV APP_ENV production
# Install any needed packages specified in requirements.txt
RUN composer install
RUN mkdir -p /var/lib/nginx/logs /var/lib/nginx/tmp/client_body && \
    chmod -R 755 /var/lib/nginx/ && \
    chown -R www-data:www-data /var/lib/nginx && \
    chown -R www-data:www-data /var/www/html/ && \
    chmod -R 775 /var/www/html

USER www-data
CMD ./entrypoint.sh
