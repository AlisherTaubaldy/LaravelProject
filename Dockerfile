FROM php:8.2.16-fpm

RUN docker-php-ext-install pdo pdo_mysql
RUN sudo apt-get install redis-server



