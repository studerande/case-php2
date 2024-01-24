FROM php:8-apache
# FROM php:7.4-apache

# RUN apt-get update && apt-get upgrade -y
#USER www-data

RUN a2enmod ssl && a2enmod rewrite

RUN service apache2 restart

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg

RUN docker-php-ext-install calendar gd mysqli pdo pdo_mysql