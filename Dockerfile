# Gunakan base image PHP 7.4 dengan Apache
FROM php:7.4-apache

# Install ekstensi yang dibutuhkan CI3
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan mod_rewrite untuk Apache
RUN a2enmod rewrite

# Copy virtual host configuration
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy semua source CodeIgniter ke /var/www/html
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

WORKDIR /var/www/html
EXPOSE 80
