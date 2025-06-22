# Use official PHP 8.2 image with Apache
FROM php:8.2-apache

# Copy project files into Apache server root
COPY . /var/www/html/

# Give permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Expose port 80 to the outside world
EXPOSE 80