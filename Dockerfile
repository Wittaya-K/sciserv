FROM php:8.2-fpm

# ติดตั้ง dependencies และ PHP extensions รวมถึง GD
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpq-dev libonig-dev libxml2-dev libzip-dev libldap2-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip ldap gd

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ตั้ง working directory
WORKDIR /var/www

# คัดลอก source code
COPY . .

# ติดตั้ง Composer packages
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
