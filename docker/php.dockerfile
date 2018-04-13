FROM php:latest
LABEL Author="Gustavo Soares"
COPY home/gustavo-soares/dev/hospital/server/composer.json var/www/composer.json

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y git
# RUN composer update

EXPOSE 3001