FROM php:8.2.12-apache

ARG APP_DIR=/var/www/html

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

RUN a2enmod rewrite

COPY ./configs/docker-php.conf /etc/apache2/conf-available/docker-php.conf

EXPOSE 80

RUN chown www-data:www-data $APP_DIR