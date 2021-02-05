FROM alpine:3.13
LABEL maintainer="Adam Volin <ajvolin@gmail.com>"

# Update apk and add dependencies
RUN apk add --update --no-cache \
                        php8 \
                        php8-bcmath \
                        php8-bz2 \
                        php8-ctype \
                        php8-curl \
                        php8-dom \
                        php8-exif \
                        php8-fileinfo \
                        php8-fpm \
                        php8-gd \
                        php8-iconv \    
                        php8-json \
                        php8-mbstring \
                        php8-openssl \
                        php8-pcntl \
                        php8-pdo \
                        php8-pdo_sqlite \
                        php8-phar \
                        php8-session \
                        php8-sqlite3 \
                        php8-tokenizer \
                        php8-xml \
                        php8-xmlwriter \
                        curl \
                        git \
                        libxml2-dev \
                        libpng-dev \
                        nginx \
                        oniguruma-dev \
                        supervisor \
                        tzdata \
                        unzip \
                        zip

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Download latest Channels Buddy release
RUN curl --silent $(curl --silent "https://api.github.com/repos/ajvolin/channels-buddy/releases/latest" | grep '"tarball_url":' | sed -E 's/.*"([^"]+)".*/\1/') -L -o channels-buddy.tar.gz && \
mkdir -p /usr/src && \
tar -zxf channels-buddy.tar.gz && \
mv ajvolin-channels-buddy*/ /usr/src/app && \
rm channels-buddy.tar.gz

# Install config files
RUN ln -sf /usr/src/app/nginx.conf /etc/nginx/nginx.conf
RUN ln -sf /usr/src/app/fpm-pool.conf /etc/php8/php-fpm.d/www.conf
RUN ln -sf /usr/src/app/php.ini-channels /etc/php8/conf.d/php-channels-settings.ini
RUN mkdir -p /etc/supervisor/conf.d/ && ln -sf /usr/src/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN ln -sf /usr/bin/php8 /usr/bin/php

# Set working directory
WORKDIR /usr/src/app

# Run setup commands
RUN chmod o+x /usr/src/app/install-composer.sh
RUN chmod o+x /usr/src/app/entrypoint.sh
RUN /usr/src/app/install-composer.sh
RUN composer install --no-dev --no-cache --no-interaction --optimize-autoloader --quiet --profile

EXPOSE 80

# Register app entry point
ENTRYPOINT ["/usr/src/app/entrypoint.sh"]

# Register healthcheck
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:80/fpm-ping