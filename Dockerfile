FROM php:fpm-alpine3.18

WORKDIR /var/www/html
RUN apk update && apk add --no-cache curl git zlib-dev libzip-dev bash

RUN docker-php-ext-install zip mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php  
RUN mv composer.phar /usr/bin/composer

COPY . .

RUN composer install

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]