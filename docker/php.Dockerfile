FROM php:7.4.6-apache

COPY php.ini /usr/local/etc/php/

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite && service apache2 restart
