FROM php:7.4-apache

# Install the PDO MySQL driver
RUN docker-php-ext-install pdo_mysql

# Use the default production configuration
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Enable Apache modules
RUN a2enmod rewrite expires headers

# Copy the site files
COPY . /var/www/html
