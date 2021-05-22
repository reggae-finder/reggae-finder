FROM php:8.0.6-fpm

RUN apt update && apt install -y git-core unzip libzip-dev nano wget libicu-dev \
    && docker-php-ext-install intl && docker-php-ext-enable intl \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip && docker-php-ext-enable zip

RUN echo "xdebug.mode=develop,coverage,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV COMPOSER_HOME /composer
ENV COMPOSER_CACHE_DIR /vendors_cache/composer
ENV PATH $PATH:/composer/vendor/bin

COPY composer-installer.sh /tmp/composer-installer.sh
RUN /tmp/composer-installer.sh

WORKDIR /var/www
EXPOSE 9000
