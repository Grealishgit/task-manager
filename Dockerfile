FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN cp .env.example .env

RUN php artisan key:generate

COPY start.sh /var/www/start.sh
RUN chmod +x /var/www/start.sh

EXPOSE 8000

CMD ["/bin/sh", "/var/www/start.sh"]