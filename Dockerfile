FROM php:8.2-apache

# เปิด mod_rewrite (ใช้กับ Laravel หรือระบบ routing)
RUN a2enmod rewrite

# ติดตั้ง PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpq-dev libonig-dev libxml2-dev libzip-dev libldap2-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip ldap gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# กำหนด working dir และคัดลอกโค้ด
WORKDIR /var/www/html
COPY . .

# ติดตั้ง Composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# กำหนด DocumentRoot สำหรับ Laravel (public/)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# เปิด port 80
EXPOSE 80
