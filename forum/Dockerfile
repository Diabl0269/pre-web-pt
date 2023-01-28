# FROM httpd:2.4

# COPY . /usr/local/apache2/htdocs/

FROM php:8.1-apache

# Enable mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Debug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY . /var/www/html/