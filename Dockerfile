# Production Dockerfile - optimized single stage
FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    apt-transport-https \
    ca-certificates \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j"$(nproc)" \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    gd \
    bcmath \
    pcntl \
    xml \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy custom PHP configuration
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# Copy application files first
COPY . .

# Set environment variable to allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Install npm dependencies and build assets
RUN npm install && npm run build

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache public/build

# initialize the database
#RUN php artisan migrate

# seed the database
#RUN php artisan migrate:fresh --seed

# Clear all Laravel caches before generating new ones
#RUN php artisan cache:clear \
#    && php artisan config:clear \
#    && php artisan route:clear \
#    && php artisan view:clear

# Generate autoloader and run optimizations
RUN composer dump-autoload --optimize 
#    && php artisan config:cache \
#    && php artisan route:cache \
#    && php artisan view:cache \
RUN php artisan storage:link

# Publish Livewire assets (after autoloader is generated)
RUN php artisan livewire:publish --assets

# Set permissions for vendor directory
RUN chmod -R 775 public/vendor

# Ensure public directory is properly copied to shared volume
RUN mkdir -p /shared/public && cp -r /var/www/html/public/. /shared/public/

# Create a script to copy public directory to shared volume on startup
RUN echo '#!/bin/bash\n\
# Copy entire public directory to shared volume (including hidden files)\n\
if [ -d "/var/www/html/public" ]; then\n\
    cp -r /var/www/html/public/. /shared/public/ 2>/dev/null || true\n\
    echo "Public directory copied to shared volume"\n\
fi\n\
\n\
# Start PHP-FPM\n\
exec php-fpm\n\
' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

EXPOSE 9000

CMD ["/usr/local/bin/start.sh"]
