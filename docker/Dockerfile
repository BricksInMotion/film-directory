FROM php:7.4-apache

# Install the PDO MySQL driver
RUN docker-php-ext-install pdo_mysql

# Use the default production configuration
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install the Apache config for the site
COPY ./docker/httpd.conf /etc/apache2/sites-available/filmdirectory.conf

# Enable Apache modules and the site
RUN a2enmod rewrite expires headers
RUN a2ensite filmdirectory
