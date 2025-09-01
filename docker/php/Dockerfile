# ---------- Base PHP image (CLI, bukan FPM) ----------
    FROM php:8.4-cli

    # System deps
    RUN apt-get update && apt-get install -y \
        zip unzip curl git libpng-dev libonig-dev libxml2-dev \
        libzip-dev libonig-dev gnupg ca-certificates \
        && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
    
    # Install Composer
    RUN curl -sS https://getcomposer.org/installer | php && \
        mv composer.phar /usr/local/bin/composer
    
    # Install Node (buat build Vite)
    # (pakai Node resmi dari NodeSource)
    RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
        && apt-get install -y nodejs
    
    WORKDIR /var/www
    
    # Copy file composer & package dulu agar layer cache efektif
    COPY composer.json composer.lock ./
    COPY package.json package-lock.json* ./
    
    # Install PHP deps (tanpa dev) & Node deps
    RUN composer install --no-dev --optimize-autoloader --no-interaction
    RUN if [ -f package.json ]; then npm ci; fi
    
    # Copy seluruh source
    COPY . .
    
    # Build Vite assets (public/build)
    RUN if [ -f package.json ]; then npm run build; fi
    
    # Laravel optimize (tanpa env file, ENV di-inject Render)
    RUN php artisan storage:link || true
    RUN php artisan config:cache || true
    RUN php artisan route:cache || true
    
    # Render akan memberikan $PORT, kita jalankan built-in server Laravel
    # Expose tidak wajib untuk Render, tapi tidak masalah
    EXPOSE 8080
    
    # Start command: serve Laravel dari folder public pada $PORT
    CMD php -d variables_order=EGPCS -S 0.0.0.0:${PORT:-8080} -t public public/index.php
    