FROM php:8.1-apache

# Ubah port Apache ke 8080 (Port default Railway)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Copy semua file project
COPY . /var/www/html/

# Expose port 8080
EXPOSE 8080
