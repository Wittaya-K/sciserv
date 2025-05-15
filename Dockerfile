FROM php:8.2-fpm

# ติดตั้ง dependency ที่จำเป็น
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev libzip-dev libldap2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip ldap gd

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# คัดลอก source code
COPY . .

# ติดตั้ง Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ตั้ง permission ให้เหมาะสม
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
