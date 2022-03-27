FROM php:8.0-fpm-alpine

RUN set -ex \
    	&& apk --no-cache add php8-mysqli nodejs yarn npm\
    	&& docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html
COPY . .
RUN chmod 777 -R .
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN php bin/console doctrine:database:create
RUN php bin/console make:migration
RUN php bin/console doctrine:migrations:migrate

RUN npm i
RUN npm run build



