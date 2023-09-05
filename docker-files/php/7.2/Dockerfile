FROM php:7.2-fpm

# Set working directory
WORKDIR /var/www/wp-web-crawler

# Create an error log file
RUN touch /var/log/error.log

# Make the file readable, writable, and executable
RUN chmod 777 /var/log/error.log

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    git \
    libbz2-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libpng-dev \
    libreadline-dev \
    libonig-dev \
    libpq-dev \
    sudo \
    unzip \
    zip \
    nano

# Install SQLite3
RUN apt-get install -y sqlite3 libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install exif pcntl bcmath gd pdo pdo_mysql pdo_sqlite sockets


# Install Redis extentions
RUN pecl install redis \
    && docker-php-ext-enable redis


# add user ubuntu, add group ubuntu
RUN useradd -rm -d /home/ubuntu -s /bin/bash -g root -G sudo,www-data -u 1000 ubuntu
RUN groupadd ubuntu

# Get latest Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer