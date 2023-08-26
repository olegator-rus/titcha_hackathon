FROM php:8.1-fpm-alpine

ADD custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini
RUN docker-php-ext-install pdo pdo_mysql sockets\
    && docker-php-ext-configure ffi --with-ffi
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

RUN sed -i 's/;ffi.enable=preload/ffi.enable=true/g' /etc/php/8.2/cli/php.ini
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install

# true
