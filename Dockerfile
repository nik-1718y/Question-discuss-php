# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy all files to the web server directory
COPY . /var/www/html/

# Expose the web server port
EXPOSE 80

