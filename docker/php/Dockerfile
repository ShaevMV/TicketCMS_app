FROM php:7.4-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

ENV HOME /var/www/html
ENV DOCKER_PHP ${HOME}/docker/php

COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug

RUN adduser --disabled-password --gecos "" user
RUN chown -R user:user /var/www/html
RUN chgrp -R user /var/www/html

