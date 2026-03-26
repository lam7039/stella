FROM php:8.4-fpm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install dependencies for Composer
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Verify installation
RUN composer --version