FROM php:8.1-cli

# Cài thư viện hệ thống cần thiết
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install zip pdo pdo_sqlite

# Copy Composer từ image chính thức
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc trong container
WORKDIR /app

# Copy mã Laravel từ thư mục con Musicweb-main vào container
COPY Musicweb-main/ .

# Cài đặt các thư viện PHP trong Laravel (nếu chưa có vendor/)
RUN composer install --no-dev

# Mở cổng cho ứng dụng Laravel chạy
EXPOSE 10000

# Lệnh chạy Laravel bằng Artisan
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
