FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
        bash \
        git \
        nano

WORKDIR /var/www/app

COPY . .

RUN docker-php-ext-install pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/app

USER www-data
RUN php artisan key:generate
RUN php artisan config:cache

CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8084"]
