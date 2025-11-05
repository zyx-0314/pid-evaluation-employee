FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    ca-certificates \
    openssh-client \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock* ./

# Ensure Composer can run in container and run non-interactively
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_DISABLE_XDEBUG_WARN=1

# Refresh composer keys to avoid pubkey verification failures
RUN composer self-update --update-keys || true

# Install PHP dependencies (non-interactive, quiet to avoid build noise)
RUN composer install --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress || \
    (composer diagnose && composer install --no-scripts --no-autoloader --prefer-dist --no-interaction)

# Copy application files
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configure Apache
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
