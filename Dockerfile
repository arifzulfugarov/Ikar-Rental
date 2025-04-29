# Use official PHP + Apache image
FROM php:8.2-apache

# Install PHP extensions needed for database support
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your PHP project files into the container
COPY . /var/www/html/

# Enable Apache mod_rewrite (useful for URLs)
RUN a2enmod rewrite


