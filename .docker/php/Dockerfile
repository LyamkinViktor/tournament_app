FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev wget zlib1g-dev libmcrypt-dev libzip-dev openssl libpng-dev \
    libicu-dev libfreetype6-dev libjpeg-dev libonig-dev

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd \
    --with-jpeg=/usr/include/ \
    --with-freetype=/usr/include

RUN docker-php-ext-install \
    pdo pdo_mysql gd intl mbstring zip

RUN pecl install xdebug-2.9.0 \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app