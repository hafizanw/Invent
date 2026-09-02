FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Docker PHP Extension Installer helper
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install PSR, Phalcon 5, PDO MySQL, and Composer
RUN install-php-extensions psr phalcon pdo_mysql zip opcache @composer

# Copy custom PHP configuration
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Set Working Directory
WORKDIR /var/www/html

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
