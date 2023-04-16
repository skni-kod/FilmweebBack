FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    postgresql-dev \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_CACHE_DIR /tmp/cache
# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install any needed packages specified in requirements.txt
RUN --mount=type=cache,target=/tmp/cache composer install

RUN php artisan config:clear \
    && php artisan config:cache \
    && php artisan key:generate \
    && php artisan optimize 

RUN chown -R www-data:www-data /var/www/html \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/bootstrap/cache

USER www-data
