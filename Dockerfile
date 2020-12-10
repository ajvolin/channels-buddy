FROM php:cli-alpine3.12

# Update apk and add dependencies
RUN apk update && \
    apk add --no-cache git \
                        curl \
                        libpng-dev \
                        oniguruma-dev \
                        libxml2-dev \
                        zip \
                        unzip \
                        composer \
                        nodejs-current \
                        npm

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd

# Clone current app code
RUN git clone https://github.com/ajvolin/channels-dvr-mapper /usr/src/app

# Set working directory
WORKDIR /usr/src/app

# Run setup commands
RUN mv /usr/src/app/storage /channel_mapper/ && \
    ln -s /channel_mapper/storage /usr/src/app/storage && \
    mkdir /channel_mapper/database && \
    touch /channel_mapper/database/database.sqlite && \
    chmod -R 777 /channel_mapper && \
    chmod o+x /usr/src/app/entrypoint.sh && \
    composer install && \
    php artisan key:generate && \
    php artisan migrate

# Start built-in PHP webserver
CMD php artisan serve --host=0.0.0.0 --port=80