FROM php:7.4-fpm-alpine

LABEL maintainer="Ammar K."

ARG DOCKER_PHP_COMPOSER=0
ARG DOCKER_PHP_OPCACHE=0
ARG DOCKER_PHP_SYMFONY=0
ARG DOCKER_PHP_XDEBUG=0
ARG PHP_FULL_INSTALL=0

COPY scripts/*.sh /usr/local/bin/

RUN set -x \
    && apk update \
    && apk add -u --no-cache --virtual .build-deps \
        freetype-dev \
        gettext-dev \
        icu-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libxslt-dev \
        libzip-dev \
    && apk add -u --no-cache \
        freetype \
        gettext \
        icu \
        libjpeg-turbo \
        libpng \
        libxslt \
        libzip \
    && docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \
    && NPROC=$(getconf _NPROCESSORS_ONLN) \
    && docker-php-ext-install -j${NPROC} \
        bcmath \
        gd \
        gettext \
        intl \
        mysqli \
        pdo_mysql \
        soap \
        sockets \
        xsl \
        zip \
    && chmod +x /usr/local/bin/*.sh \
    && docker-php-extensions-installer.sh \
    && apk del .build-deps
