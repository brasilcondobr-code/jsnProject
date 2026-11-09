ARG WORDPRESS_IMAGE=wordpress:6.8-php8.3-fpm-alpine
FROM ${WORDPRESS_IMAGE}

ARG ENABLE_XDEBUG=0

COPY docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini
COPY docker/php/docker-php-ext-xdebug.ini /tmp/docker-php-ext-xdebug.ini

RUN if [ "$ENABLE_XDEBUG" = "1" ]; then \
        apk add --no-cache --virtual .xdebug-build $PHPIZE_DEPS linux-headers \
        && pecl install xdebug \
        && docker-php-ext-enable xdebug \
        && cp /tmp/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && apk del .xdebug-build; \
    fi \
    && rm -f /tmp/docker-php-ext-xdebug.ini
