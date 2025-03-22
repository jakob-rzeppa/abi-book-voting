FROM php:7.4-fpm

# INSTALL ZIP TO USE COMPOSER
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip

# INSTALL AND UPDATE COMPOSER
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update

COPY src /var/www/html
COPY composer.json /var/www/html/composer.json
COPY composer.lock /var/www/html/composer.lock

WORKDIR /var/www/html

RUN composer install