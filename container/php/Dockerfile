FROM php:8.1.12-fpm
COPY "./php.ini-development" "${PHP_INI_DIR}/php.ini"
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug