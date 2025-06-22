# Use official PHP image with Apache
FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Set server name (to avoid warnings)
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy all project files into Apache root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose default port
EXPOSE 80
