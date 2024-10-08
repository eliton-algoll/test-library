FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY .. .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

RUN composer install --optimize-autoloader --no-dev

EXPOSE 9000

CMD ["php-fpm"]
