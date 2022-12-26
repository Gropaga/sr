FROM php:8.0-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN set -eux; \
    chmod +x /usr/local/bin/install-php-extensions; \
    install-php-extensions \
    amqp \
    apcu \
    bcmath \
    bz2 \
    calendar \
    decimal \
    enchant \
    event \
    exif \
    gd \
    gettext \
    gmp \
    igbinary \
    imagick \
    intl \
    lzf \
    memcached \
    mongodb \
    msgpack \
    mysqli \
    opcache \
    pcntl \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    redis \
    sockets \
    swoole \
    tidy \
    timezonedb \
    uuid \
    xlswriter \
    xsl \
    yac \
    yaml \
    zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o ; wait-for-it db:5432 -- bin/console doctrine:migrations:migrate ;  php-fpm 

EXPOSE 9000
