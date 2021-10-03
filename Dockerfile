FROM composer:2 AS composer_stage
ARG APP_ENV='prod'
ARG COMPOSER_AUTH
ENV COMPOSER_AUTH ${COMPOSER_AUTH}

WORKDIR /vendor
COPY ./composer.json ./
COPY ./composer.lock ./

RUN composer install --ignore-platform-reqs --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts  \
    && rm -rf /root/.composer

FROM php:8-fpm as base
ARG APCU_VERSION=5.1.20

RUN apt-get update
RUN apt-get install -y unzip git tini nginx
RUN docker-php-ext-install opcache pdo
RUN apt-get install -y \
        && (yes '' | pecl install -f apcu-${APCU_VERSION}) \
        && docker-php-ext-enable apcu
RUN pecl clear-cache && docker-php-source delete && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /etc/nginx/sites-enabled/*


FROM base as production
ARG PHP_INI_DIR="/usr/local/etc/php"
ARG UID

# disable php access logs, nginx access logs are enough
RUN sed -i "s/^\(access.log\).*/\1 = \/dev\/null/" /usr/local/etc/php-fpm.d/docker.conf

# enable php production config
RUN ln -s -f $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini


COPY .docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY .docker/entrypoint.sh /usr/local/bin/docker-entrypoint
COPY .docker/php-config.ini $PHP_INI_DIR/conf.d/php-config.ini
RUN ls -la /usr/local/bin

WORKDIR /var/www

COPY --from=composer_stage /vendor ./
COPY . ./

RUN mkdir ./var/db
RUN usermod -u $UID www-data
RUN chown -R www-data:www-data logs ./var/*

# clean up some files that are not needed in production image
RUN rm -rf /usr/bin/composer .docker Dockerfile  composer.json composer.lock README.md

ENTRYPOINT ["tini"]
CMD ["docker-entrypoint", "--"]

FROM production as development
ARG PHP_INI_DIR="/usr/local/etc/php"

# add the composer script
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# enable php development config
RUN ln -s -f  $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
#RUN sed -i 's/^opcache.validate_timestamps = 0/' $PHP_INI_DIR/conf.d/php-config.ini

# install and configure xdebug that will be triggered by cookie value
RUN pecl install xdebug-3.0.2 && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=true" >> $PHP_INI_DIR/conf.d/xdebug.ini