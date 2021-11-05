FROM php:7.2-apache

RUN apt-get update 

RUN docker-php-ext-install pdo pdo_mysql 

RUN a2enmod rewrite 

WORKDIR /var/www/html
