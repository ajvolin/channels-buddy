#!/bin/sh

[ -f /channel_mapper/database.sqlite ] || { touch /channel_mapper/database.sqlite; chmod -R 777 /channel_mapper; php artisan migrate; }
[ -e /channel_mapper/storage ] || { mv /usr/src/app/storage /channel_mapper/; ln -s /channel_mapper/storage /usr/src/app/storage; }

cd /usr/src/app

sed '/^CHANNELS_SERVER_IP=/{h;s/=.*/='"$CHANNELS_SERVER_IP"'/};${x;/^$/{s//CHANNELS_BACKEND_IP='"$CHANNELS_SERVER_IP"'/;H};x}' -i .env
sed '/^CHANNELS_SERVER_PORT=/{h;s/=.*/='"$CHANNELS_SERVER_PORT"'/};${x;/^$/{s//CHANNELS_BACKEND_PORT='"$CHANNELS_SERVER_PORT"'/;H};x}' -i .env

while :
do
    echo "Channels server: $CHANNELS_SERVER_IP:$CHANNELS_SERVER_PORT"
    echo "Starting application"
    php artisan serve --host=0.0.0.0 --port=80
done

