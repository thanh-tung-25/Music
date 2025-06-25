FROM php:8.2-cli

# Cài thư viện cần thiết
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install zip pdo pdo_sqlite

# Cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thư mục gốc dự án
WORKDIR /app

# Copy toàn bộ dự án vào container
COPY . .

# Cài package Laravel
RUN composer install --no-dev \
 && php artisan config:clear \
 && php artisan key:generate \
 && mkdir -p /tmp \
 && touch /tmp/database.sqlite \
 && chmod -R 777 /tmp/database.sqlite \
 && chmod -R 775 storage bootstrap/cache

# Mở port
EXPOSE 10000

# Chạy Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
