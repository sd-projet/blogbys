FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN echo "display_errors=Off" > /usr/local/etc/php/conf.d/production.ini

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/miniatures

EXPOSE 80