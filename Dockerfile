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

# Buat file .env secara manual dengan konfigurasi PostgreSQL Neon.tech
RUN echo "APP_NAME=Laravel" > .env \
    && echo "APP_ENV=production" >> .env \
    && echo "APP_KEY=" >> .env \
    && echo "APP_DEBUG=true" >> .env \
    && echo "APP_URL=https://task-manager-smpl.vercel.app" >> .env \
    && echo "DB_CONNECTION=pgsql" >> .env \
    && echo "DB_HOST=ep-withered-rain-a1w0t4y9-pooler.ap-southeast-1.aws.neon.tech" >> .env \
    && echo "DB_PORT=5432" >> .env \
    && echo "DB_DATABASE=neondb" >> .env \
    && echo "DB_USERNAME=neondb_owner" >> .env \
    && echo "DB_PASSWORD=npg_d8qB8OkmcSLZ" >> .env

RUN composer install --no-dev --optimize-autoloader

# Generate APP_KEY
RUN php artisan key:generate --force

# Konfigurasi Apache DocumentRoot ke folder public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Berikan izin akses folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
