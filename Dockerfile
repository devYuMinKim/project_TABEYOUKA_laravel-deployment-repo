FROM php:fpm-alpine3.18

WORKDIR /var/www/html
RUN apk update && apk add --no-cache curl git zlib-dev libzip-dev bash

RUN curl -sS https://getcomposer.org/installer | php  
RUN mv composer.phar /usr/bin/composer

RUN docker-php-ext-install zip mysqli pdo pdo_mysql

COPY . .

RUN composer global require laravel/installer
RUN ["/bin/bash", "-c", "echo PATH=$PATH:~/.composer/vendor/bin/ >> ~/.bashrc"]
RUN ["/bin/bash", "-c", "source ~/.bashrc"]

RUN composer install

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
