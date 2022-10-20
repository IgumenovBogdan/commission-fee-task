FROM php:8.1-fpm

RUN apt-get update && apt-get install -y libpq-dev libicu-dev ssh lsof \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql intl

WORKDIR /var/www
