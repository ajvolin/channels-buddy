#!/bin/sh

[ -f /channel_mapper/database.sqlite ] || { touch /channel_mapper/database.sqlite; chmod -R 777 /channel_mapper; php artisan migrate; }

cd /usr/src/app

sed '/^CHANNELS_BACKEND_IP=/{h;s/=.*/='"$CHANNELS_BACKEND_IP"'/};${x;/^$/{s//CHANNELS_BACKEND_IP='"$CHANNELS_BACKEND_IP"'/;H};x}' -i .env
sed '/^CHANNELS_BACKEND_PORT=/{h;s/=.*/='"$CHANNELS_BACKEND_PORT"'/};${x;/^$/{s//CHANNELS_BACKEND_PORT='"$CHANNELS_BACKEND_PORT"'/;H};x}' -i .env

while :
do
    echo "Channels server: $CHANNELS_BACKEND_IP:$CHANNELS_BACKEND_PORT"
    echo "Starting application"
    php artisan serve --host=0.0.0.0 --port=80
done

