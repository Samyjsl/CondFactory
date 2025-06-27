FROM php:8.0-apache

RUN docker-php-ext-install mysqli

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

RUN cp "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"