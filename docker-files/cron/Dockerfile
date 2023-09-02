FROM php:7.4-fpm-alpine

# Install dependencies
RUN apk update && apk add --no-cache \
    mysql-dev \
    curl \
    nano

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Create a cron job file
RUN touch /var/log/cron.log
COPY docker-files/cron/config/crontab /etc/crontabs/root

# Start the cron service
CMD ["crond", "-f"]
