FROM php:8.1-fpm
########################################################################################################################
# Install system dependencies
########################################################################################################################
RUN apt-get update && apt-get install -y \
    gnupg \
    apt-transport-https \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libicu-dev \
    libxml2-dev \
    libssl-dev \
    libzip-dev \
    g++ \
    curl \
    wget \
    git \
    zip \
    locales \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

RUN git clone --depth 1 https://github.com/edenhill/librdkafka.git \
    && ( \
    cd librdkafka \
    && ./configure --install-deps \
    && make \
    && make install \
    ) \
    && pecl install rdkafka \
    && echo "extension=rdkafka.so" > /usr/local/etc/php/conf.d/rdkafka.ini

########################################################################################################################
# Install Docker-PHP Extensions, php 8.x and it's dependencies
########################################################################################################################
RUN docker-php-ext-install pdo \
    pdo_mysql

RUN pecl install -o -f redis && \
    docker-php-ext-enable redis

RUN pecl install -f igbinary && \
    docker-php-ext-enable igbinary

## Install APCu and APC backward compatibility
RUN pecl install -f apcu && \
    docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer

COPY . /var/www
WORKDIR /var/www

RUN composer install
