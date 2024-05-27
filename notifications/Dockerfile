# Use the official PHP image with Apache
FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    wget

# Enable Apache modules
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install intl mbstring opcache pdo pdo_mysql xml

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the project files
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install project dependencies
RUN composer install

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html

# Expose the port Apache is running on
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]