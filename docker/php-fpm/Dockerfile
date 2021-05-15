FROM php:8.0.6-fpm

ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

RUN apt update && apt install -y git-core unzip nano \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY composer-installer.sh /tmp/composer-installer.sh
RUN /tmp/composer-installer.sh
