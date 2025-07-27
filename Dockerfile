FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev libpng-dev \
    libjpeg-dev libfreetype6-dev libssl-dev libpq-dev libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath pcntl xml curl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

# Install composer dependencies
RUN composer install
# --no-dev
# --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Production optimizations
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache && composer dump-autoload && php artisan migrate && php artisan migrate:fresh --seed

# Link Storage to Public
RUN php artisan storage:link

EXPOSE 9000

CMD ["php-fpm"]
