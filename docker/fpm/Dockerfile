FROM php:8.0-fpm-alpine

RUN set -ex \
    	&& apk --no-cache add nodejs php8-mysqli npm\
    	&& docker-php-ext-install pdo pdo_mysql\
		&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
COPY . .
RUN chmod 777 -R . && composer install && npm i && npm run build



