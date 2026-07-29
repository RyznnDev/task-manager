FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel & PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql

# Ubah DocumentRoot Apache ke folder public Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Aktifkan mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# Salin seluruh file project ke dalam container
COPY . /var/www/html

# Atur izin akses folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

