FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

RUN apk update && apk add libpq-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install pdo pdo_pgsql

COPY .. .

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk add nodejs npm