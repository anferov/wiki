FROM php:7.4.7-fpm-alpine3.12

ARG APP_ENV=dev
ENV PHPIZE_DEPS autoconf 		dpkg-dev dpkg 		file 		g++ 		gcc 		libc-dev 		make 		pkgconf 		re2c

# Install any custom system requirements here
RUN apk update
RUN apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} gcc build-base autoconf
RUN apk add --no-cache tzdata \
 git \
 curl \
 openssl \
 openssh \
 bash \
 vim \
 mc \
 zlib-dev \
 oniguruma-dev \
 libzip-dev \
 bzip2-dev \
 bzip2 \
 libxml2-dev \
 libmcrypt-dev \
 icu-dev \
 libpng-dev \
 freetype-dev \
 libjpeg-turbo-dev \
 sqlite-dev

RUN pecl install redis apcu mcrypt
RUN docker-php-ext-enable redis apcu mcrypt

# Install various PHP extensions
RUN docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-configure pdo_sqlite --with-pdo-sqlite \
    && docker-php-ext-configure mbstring --enable-mbstring \
    && docker-php-ext-configure soap --enable-soap \
    && docker-php-ext-install \
        bcmath \
        intl \
        mbstring \
        mysqli \
        pcntl \
        pdo_mysql \
        pdo_sqlite \
        soap \
        sockets \
        zip \
        gd \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd \
  && docker-php-ext-install opcache \
  && docker-php-ext-enable opcache

# AST
RUN git clone https://github.com/nikic/php-ast /usr/src/php/ext/ast/ && \
    docker-php-ext-configure ast && \
    docker-php-ext-install ast

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Copy opcache configration
COPY ./docker/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Install xDebug, if enabled
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    # Install the xdebug extension
    pecl install xdebug && \
    docker-php-ext-enable xdebug \
;fi

# Copy xdebug configration for remote debugging
COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Copy timezone configration
COPY ./docker/php-fpm/timezone.ini /usr/local/etc/php/conf.d/timezone.ini

# Set timezone
RUN rm -f /etc/localtime || true
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN "date"

# Short open tags fix - another Symfony requirements
COPY ./docker/php-fpm/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Composer
RUN wget https://getcomposer.org/installer -O composer-setup.php \
    && php composer-setup.php --install-dir=/bin --filename=composer \
    && mkdir -p /srv/www/.composer \
    && chmod 775 /srv/www/.composer \
    && chown www-data:www-data -R /srv/www \
    && chmod 775 /usr/local/bin/docker-php-entrypoint

USER www-data

RUN mkdir -p /srv/www/wiki/{var/{log,cache},vendor}

WORKDIR /srv/www/wiki
COPY --chown=www-data ./source/app/composer.json composer.json
COPY --chown=www-data ./source/app/composer.lock composer.lock
RUN composer install --prefer-dist --no-interaction --no-scripts -v \
    && composer dump-autoload -o --apcu --no-interaction --no-scripts
#COPY --chown=www-data ../../source/app ./