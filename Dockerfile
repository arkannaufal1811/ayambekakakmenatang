FROM php:8.1-apache

# Copy semua file project ke folder web server
COPY . /var/www/html/

# Expose port 80 untuk web server
EXPOSE 80
