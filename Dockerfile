FROM alpine:3.12
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
RUN mv /usr/src/repo/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
RUN mv /usr/src/repo/php.ini-channels /etc/php7/conf.d/php-channels-settings.ini
RUN mkdir -p /etc/supervisor/conf.d/ && mv /usr/src/repo/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mv /usr/src/repo/entrypoint.sh /usr/src/app/entrypoint.sh
RUN mkdir /channel_mapper

# Remove repo folder
RUN rm -rf /usr/src/repo

# Set working directory
WORKDIR /usr/src/app

# Run setup commands
RUN chmod o+x /usr/src/app/entrypoint.sh
RUN composer install

# Add www user
RUN adduser -D -g 'app' app

# Modify permissions
RUN chown app:app -R /usr/src/app && \
    chown app:app -R /var/run && \
    chown app:app -R /var/lib/nginx && \
    chown app:app -R /var/log/nginx && \
    chown app:app -R /channel_mapper

EXPOSE 8087

# Switch to non-privileged user
USER app

# Register app entry point
ENTRYPOINT ["/usr/src/app/entrypoint.sh"]

# Register healthcheck
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8087/fpm-ping