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

# Clone github repo
RUN git clone https://github.com/ajvolin/channels-dvr-mapper /usr/src/repo

# Add entrypoint and app code
RUN mv /usr/src/repo/channel-mapper /usr/src/app
RUN mv /usr/src/repo/php.ini-channels $PHP_INI_DIR/php.ini
RUN mv /usr/src/repo/entrypoint.sh /usr/src/app/entrypoint.sh

# Set working directory
WORKDIR /usr/src/app

# Run setup commands
RUN chmod o+x /usr/src/app/entrypoint.sh
RUN composer install

ENTRYPOINT ["/usr/src/app/entrypoint.sh"]