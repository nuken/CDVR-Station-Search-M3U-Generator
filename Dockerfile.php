# Use the official PHP-FPM Alpine image as a base
FROM php:8.2-fpm-alpine

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application source code into the container
# We only need the PHP file here
COPY src/proxy.php .