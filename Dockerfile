FROM php:8.4-fpm

# INSTALL ZIP TO USE COMPOSER
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

# INSTALL AND UPDATE COMPOSER
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update

COPY src /var/www/html
COPY composer.json /var/www/html/composer.json
COPY composer.lock /var/www/html/composer.lock

WORKDIR /var/www/html

RUN composer install