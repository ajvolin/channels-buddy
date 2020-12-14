#!/bin/sh

# Ensure database file exists
touch /channel_mapper/database.sqlite
# Symlink database to app database folder
ln -s /channel_mapper/database.sqlite /usr/src/app/database/database.sqlite

# Move app storage folder to bound volume if it doesn't exist
[ -e /channel_mapper/storage ] || { mv /usr/src/app/storage /channel_mapper/; }
# Symlink bound storage folder to app storage folder
ln -s /channel_mapper/storage /usr/src/app/storage

# Initialize .env file if it doesn't exist
[ -f /channel_mapper/.env ] || { cp /usr/src/app/.env.channels /channel_mapper/.env; ln -s /channel_mapper/.env /usr/src/app/.env; chmod 777 /channel_mapper/.env; php artisan key:generate; }

# Set permissions on bound volume
chmod -R 777 /channel_mapper

# Change working directory to app folder
cd /usr/src/app

# Set .env vars for Channels server IP(s)
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

# Run database migrations
php artisan migrate --force

while :
do
    echo "Channels server: $CHANNELS_SERVER_IP:$CHANNELS_SERVER_PORT"
    echo "Starting application"
    php artisan serve --host=0.0.0.0 --port=80
done