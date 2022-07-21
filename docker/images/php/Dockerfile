FROM php:8.1.6-fpm-alpine3.14

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk update \
    && apk add --no-cache \
    bash \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    postgresql-libs \
    postgresql-dev \
    && docker-php-ext-configure \
    intl \
    && docker-php-ext-install \
    intl \
    opcache \
    pgsql \
    pdo_pgsql \
    && apk del  \
    postgresql-dev
