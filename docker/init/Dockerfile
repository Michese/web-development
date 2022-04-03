FROM php:8.0-fpm-alpine

RUN set -ex \
    	&& apk --no-cache add nodejs php8-mysqli\
    	&& docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html

CMD sleep 15; php bin/console doctrine:database:create && php bin/console -q doctrine:migrations:migrate; php bin/console -q doctrine:fixtures:load