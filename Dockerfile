FROM php:cli-alpine3.12
LABEL maintainer="Adam Volin <ajvolin@gmail.com>"

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

# Set working directory
WORKDIR /usr/src/app

# Add entrypoint and app code
ADD entrypoint.sh /usr/src/app/entrypoint.sh
ADD ./channel-mapper /usr/src/app

# Run setup commands
RUN chmod o+x /usr/src/app/entrypoint.sh
RUN composer install    
RUN php artisan key:generate

ENTRYPOINT ["/usr/src/app/entrypoint.sh"]