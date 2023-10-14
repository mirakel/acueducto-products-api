FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY composer*.json .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts

COPY . .

EXPOSE 9000

ENTRYPOINT ["./entrypoint.sh"]
