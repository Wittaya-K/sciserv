FROM php:8.2-apache

# เปิดใช้งาน mod_rewrite (ใช้กับ Laravel หรือ framework อื่น ๆ)
RUN a2enmod rewrite

# ติดตั้ง PHP extensions ที่ต้องใช้
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpq-dev libonig-dev libxml2-dev libzip-dev libldap2-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip ldap gd

# คัดลอกซอร์สโค้ด
WORKDIR /var/www/html
COPY . .

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# แก้ไข Apache DocumentRoot ถ้าคุณใช้ Laravel
# (โดย Laravel อยู่ใน `public/` folder)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/a
