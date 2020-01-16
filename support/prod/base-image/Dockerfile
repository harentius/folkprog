FROM php:7.3-fpm-alpine

# php fpm config
RUN echo "pm.start_servers = 1" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "pm.max_children = 1" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "pm.max_spare_servers = 1" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
# php extensions deps
    && apk update -q && apk upgrade -q \
    && apk add \
        gd \
        libpng \
        curl libcurl \
        ca-certificates \
        libjpeg \
        libpng \
        icu \
    && apk add -q --virtual build-deps \
    build-base \
    icu-dev \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    jpeg-dev \
    gd-dev \
    curl-dev \
    && docker-php-ext-install gd intl pdo_mysql curl \
    && apk del -q build-deps \
# apcu
    && docker-php-source extract \
    && apk add --no-cache --virtual .phpize-deps-configure $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del .phpize-deps-configure \
    && docker-php-source delete \
# nginx install
    && apk update \
    && apk add nginx \
# forward request and error logs to docker log collector
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
# supervisor install
    && apk add supervisor && mkdir -p /var/log/supervisor

COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/nginx.vh.conf /etc/nginx/conf.d/default.conf
COPY config/supervisord.conf /etc/supervisord.conf

STOPSIGNAL SIGTERM

EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord"]
CMD ["-n", "-c", "/etc/supervisord.conf"]