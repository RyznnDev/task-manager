FROM php:8.2-apache

# 1. Install ekstensi & dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip

# 2. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Tentukan direktori kerja
WORKDIR /var/www/html

# 4. Salin seluruh project
COPY . .

# 5. Install vendor via composer
RUN composer install --no-dev --optimize-autoloader

# 6. UBAH DOCUMENT ROOT APACHE KE /var/www/html/public
RUN sed -i 's!/var/www/html/public!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!DocumentRoot /var/www/html!DocumentRoot /var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 7. Aktifkan mod_rewrite
RUN a2enmod rewrite

# 8. Berikan izin folder storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
