FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Buat file .env dari .env.example jika belum ada
RUN cp .env.example .env

# Install vendor dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate APP_KEY dan clear cache agar tidak error 500
RUN php artisan key:generate --force
RUN php artisan config:clear
RUN php artisan cache:clear

# Konfigurasi Apache DocumentRoot ke folder public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Berikan izin akses folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
