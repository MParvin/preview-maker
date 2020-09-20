FROM composer:latest

RUN apk update && \
        apk add git openjdk11 libreoffice

WORKDIR /app

CP . .

RUN composer install

ENTRYPOINT ["php","bin/console.php"]
