FROM php:8.0.6-fpm

RUN apt update && apt install -y git-core unzip libzip-dev nano wget libicu-dev \
    && docker-php-ext-install intl \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip

RUN echo "xdebug.mode=develop,coverage,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN useradd --create-home --shell /bin/bash -g operator operator

ENV COMPOSER_HOME /home/operator/.composer
ENV COMPOSER_CACHE_DIR /vendors_cache/composer

ENV PATH $PATH:/home/operator/.composer/vendor/bin

COPY composer-installer.sh /tmp/composer-installer.sh
RUN mkdir /home/operator/.composer && chown -R operator:operator /home/operator/.composer \
    && mkdir /vendors_cache && chown -R operator:operator /vendors_cache \
    && /tmp/composer-installer.sh && rm /tmp/composer-installer.sh

USER operator

WORKDIR /home/operator
EXPOSE 9000
