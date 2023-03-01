FROM php:8.1.12-fpm
# 設定値
COPY "./php.ini-development" "${PHP_INI_DIR}/php.ini"
RUN apt-get update && apt-get install -y git zip unzip node.js npm
# Xdebug
RUN pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# MariaDB
RUN docker-php-ext-install pdo_mysql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# コンテナ操作ユーザ
RUN useradd --create-home app
USER app
WORKDIR /home/app