#!/bin/sh

[ -f /channel_mapper/.env ] || { cp /usr/src/app/.env.channels /channel_mapper/.env; ln -s /channel_mapper/.env /usr/src/app/.env; php artisan key:generate; }
[ -f /channel_mapper/database.sqlite ] || { touch /channel_mapper/database.sqlite; chmod -R 777 /channel_mapper; ln -s /channel_mapper/database.sqlite /usr/src/app/database/database.sqlite; }
[ -e /channel_mapper/storage ] || { mv /usr/src/app/storage /channel_mapper/; ln -s /channel_mapper/storage /usr/src/app/storage; }

cd /usr/src/app

sed '/^CHANNELS_SERVER_IP=/{h;s/=.*/='"$CHANNELS_SERVER_IP"'/};${x;/^$/{s//CHANNELS_SERVER_IP='"$CHANNELS_SERVER_IP"'/;H};x}' -i .env
sed '/^CHANNELS_SERVER_PORT=/{h;s/=.*/='"$CHANNELS_SERVER_PORT"'/};${x;/^$/{s//CHANNELS_SERVER_PORT='"$CHANNELS_SERVER_PORT"'/;H};x}' -i .env

if [[ -z "${CHANNELS_SERVER_IP_FOR_PLAYLIST}" ]]; then
    sed '/^CHANNELS_SERVER_IP_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_IP"'/};${x;/^$/{s//CHANNELS_SERVER_IP_FOR_PLAYLIST='"$CHANNELS_SERVER_IP"'/;H};x}' -i .env
else
    sed '/^CHANNELS_SERVER_IP_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_IP_FOR_PLAYLIST"'/};${x;/^$/{s//CHANNELS_SERVER_IP_FOR_PLAYLIST='"$CHANNELS_SERVER_IP_FOR_PLAYLIST"'/;H};x}' -i .env
fi

if [[ -z "${CHANNELS_SERVER_PORT_FOR_PLAYLIST}" ]]; then
    sed '/^CHANNELS_SERVER_PORT_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_PORT"'/};${x;/^$/{s//CHANNELS_SERVER_PORT_FOR_PLAYLIST='"$CHANNELS_SERVER_PORT"'/;H};x}' -i .env
else
    sed '/^CHANNELS_SERVER_PORT_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_PORT_FOR_PLAYLIST"'/};${x;/^$/{s//CHANNELS_SERVER_PORT_FOR_PLAYLIST='"$CHANNELS_SERVER_PORT_FOR_PLAYLIST"'/;H};x}' -i .env
fi

php artisan migrate;

while :
do
    echo "Channels server: $CHANNELS_SERVER_IP:$CHANNELS_SERVER_PORT"
    echo "Starting application"
    php artisan serve --host=0.0.0.0 --port=80
done