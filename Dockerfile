# Use PHP with Apache
FROM php:8.2-apache

# -----------------------------
# [NO CHANGE] System dependencies
# -----------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    wget \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip

# -----------------------------
# [NO CHANGE]
# -----------------------------
RUN a2enmod rewrite

# -----------------------------
# [NO CHANGE]
# -----------------------------
WORKDIR /var/www/html
COPY . .

# -----------------------------
# ✅ ADD (Git ownership fix)
# -----------------------------
RUN git config --global --add safe.directory /var/www/html
RUN git config --global --add safe.directory /var/www/html/core

# -----------------------------
# [NO CHANGE] Install Composer
# -----------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -----------------------------
# [NO CHANGE]
# -----------------------------
COPY php.ini /usr/local/etc/php/php.ini

# -----------------------------
# ✅ ADD (Composer install INSIDE Docker – production style)
# -----------------------------
WORKDIR /var/www/html/core
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# -----------------------------
# ⚠️ PERMISSION FIX (777 → 775)
# -----------------------------
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
