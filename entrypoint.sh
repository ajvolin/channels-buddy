#!/bin/sh

cd /usr/src/app

while :
do
    echo "Channels server: $CHANNELS_BACKEND_IP:$CHANNELS_BACKEND_PORT"
    echo "Starting application"
    php artisan serve --host=0.0.0.0 --port=80
done