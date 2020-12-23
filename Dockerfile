FROM alpine:edge
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
                        php8-session \
                        php8-sqlite3 \
                        php8-tokenizer \
                        php8-xml \
                        php8-xmlwriter \
                        composer \
                        curl \
                        git \
                        libxml2-dev \
                        libpng-dev \
                        nodejs-current \
                        npm \
                        nginx \
                        oniguruma-dev \
                        supervisor \
                        unzip \
                        zip \
                        libva

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Clone github repo
RUN git clone https://github.com/ajvolin/channels-dvr-mapper /usr/src/repo

# Add app code, config files, and entrypoint
RUN mv /usr/src/repo/channel-mapper /usr/src/app
RUN mv /usr/src/repo/nginx.conf /etc/nginx/nginx.conf
RUN mv /usr/src/repo/fpm-pool.conf /etc/php8/php-fpm.d/www.conf
RUN mv /usr/src/repo/php.ini-channels /etc/php8/conf.d/php-channels-settings.ini
RUN mkdir -p /etc/supervisor/conf.d/ && mv /usr/src/repo/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mv /usr/src/repo/entrypoint.sh /usr/src/app/entrypoint.sh

# Remove repo folder
RUN rm -rf /usr/src/repo

# Set working directory
WORKDIR /usr/src/app

# Run setup commands
RUN chmod o+x /usr/src/app/entrypoint.sh
RUN composer install
RUN composer clearcache

EXPOSE 80

# Register app entry point
ENTRYPOINT ["/usr/src/app/entrypoint.sh"]

# Register healthcheck
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:80/fpm-ping