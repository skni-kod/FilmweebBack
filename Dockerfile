FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    postgresql-dev \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    nginx

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
COPY ./nginx.conf /etc/nginx/http.d/default.conf
ENV APP_ENV production
# Install any needed packages specified in requirements.txt
RUN --mount=type=cache,target=/tmp/cache composer install
RUN chown -R root:root /var/www/html/storage && \
    chmod -R 775 /var/www/html/storage && \
    chmod 775 entrypoint.sh

CMD ./entrypoint.sh
