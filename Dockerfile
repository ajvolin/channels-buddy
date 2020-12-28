FROM alpine:edge
LABEL maintainer="Adam Volin <ajvolin@gmail.com>"

# Update apk and add dependencies
RUN apk add --update --no-cache \
                        php7 \
                        php7-bcmath \
                        php7-bz2 \
                        php7-ctype \
                        php7-curl \
                        php7-dom \
                        php7-exif \
                        php7-fileinfo \
                        php7-fpm \
                        php7-gd \
                        php7-iconv \    
                        php7-json \
                        php7-mbstring \
                        php7-openssl \
                        php7-pcntl \
                        php7-pdo \
                        php7-pdo_sqlite \
                        php7-session \
                        php7-sqlite3 \
                        php7-tokenizer \
                        php7-xml \
                        php7-xmlwriter \
                        composer \
                        curl \
                        git \
                        libxml2-dev \
                        libpng-dev \
                        nginx \
                        oniguruma-dev \
                        supervisor \
                        unzip \
                        zip \
                        libva

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Clone github repo
RUN git clone https://github.com/ajvolin/channels-buddy /usr/src/app

# Install config files
RUN ln -sf /usr/src/app/nginx.conf /etc/nginx/nginx.conf
RUN ln -sf /usr/src/app/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
RUN ln -sf /usr/src/app/php.ini-channels /etc/php7/conf.d/php-channels-settings.ini
RUN mkdir -p /etc/supervisor/conf.d/ && ln -sf /usr/src/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set working directory
WORKDIR /usr/src/app

# Run setup commands
RUN chmod o+x /usr/src/app/entrypoint.sh
RUN composer install --no-dev --no-cache --no-interaction --optimize-autoloader --quiet --profile

EXPOSE 80

# Register app entry point
ENTRYPOINT ["/usr/src/app/entrypoint.sh"]

# Register healthcheck
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:80/fpm-ping