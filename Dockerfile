# Gunakan image PHP dan Apache
FROM php:8.1-apache

# Salin file-filen yang diperlukan ke dalam container
COPY . /var/www/html/

# Instal dependensi
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Atur direktori kerja
WORKDIR /var/www/html

# Expose port yang digunakan oleh Apache
EXPOSE 80

# Perintah yang dijalankan saat container berjalan
CMD ["apache2-foreground"]