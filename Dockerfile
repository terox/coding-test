# syntax = docker/dockerfile:1.2

FROM php:8.3-fpm-alpine as php_base
LABEL Description="The PHP environment base"

ENV TZ=Europe/Madrid

RUN apk add --no-cache git

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions zip bcmath @composer;

WORKDIR /app

FROM php_base AS app_dev
LABEL Description="The PHP environment for development"

ENV XDEBUG_MODE=coverage
ENV APP_ENV=dev

RUN install-php-extensions xdebug; \
  rm /usr/local/bin/install-php-extensions;