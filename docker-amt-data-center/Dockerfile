FROM php:8.3-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libmagickwand-dev \
    libpq-dev \
    gnupg \
    fonts-liberation \
    libnss3 \
    libnspr4 \
    libatk1.0-0 \
    libatk-bridge2.0-0 \
    libcups2 \
    libdrm2 \
    libxkbcommon0 \
    libxcomposite1 \
    libxdamage1 \
    libxrandr2 \
    libgbm1 \
    libasound2 \
    libpango-1.0-0 \
    libcairo2 \
    libatspi2.0-0 \
    libx11-xcb1 \
    libxshmfence1 \
    libxfixes3 \
    libxext6 \
    libxrender1 \
    libxcb1 \
    libdbus-1-3 \
    libglib2.0-0 \
    wget \
    gnupg \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 🧠 Install Chromium (bukan Chrome)
RUN apt-get update && apt-get install -y chromium chromium-common chromium-driver

# 🧩 Symlink ke lokasi yang bisa dipakai Browsershot
RUN ln -s /usr/bin/chromium /usr/bin/google-chrome

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Tambah user non-root
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

WORKDIR /var/www
USER $user
