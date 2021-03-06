#!/bin/sh

# Set umask
umask 000

# Ensure database file exists
touch /channels_buddy/database.sqlite
# Symlink database to app database folder
ln -sf /channels_buddy/database.sqlite /usr/src/app/database/database.sqlite

# Move app storage folder to bound volume if it doesn't exist
[ -e /channels_buddy/storage ] || { mv /usr/src/app/storage /channels_buddy/; }
# Symlink bound storage folder to app storage folder
ln -sf /channels_buddy/storage /usr/src/app/storage

# Initialize .env file if it doesn't exist
[ -f /channels_buddy/.env ] || { cp /usr/src/app/.env.channels /channels_buddy/.env; chmod 777 /channels_buddy/.env; ln -sf /channels_buddy/.env /usr/src/app/.env; php artisan key:generate; }
# Ensure .env is symlinked
ln -sf /channels_buddy/.env /usr/src/app/.env;

# Set permissions on bound volume
chmod -R 777 /channels_buddy

# Change working directory to app folder
cd /usr/src/app

# Set .env vars for Channels server IP(s)
sed '/^CHANNELS_SERVER_IP=/{h;s/=.*/='"$CHANNELS_SERVER_IP"'/};${x;/^$/{s//CHANNELS_SERVER_IP='"$CHANNELS_SERVER_IP"'/;H};x}' -i /channels_buddy/.env
sed '/^CHANNELS_SERVER_PORT=/{h;s/=.*/='"$CHANNELS_SERVER_PORT"'/};${x;/^$/{s//CHANNELS_SERVER_PORT='"$CHANNELS_SERVER_PORT"'/;H};x}' -i /channels_buddy/.env

if [[ -z "${CHANNELS_SERVER_IP_FOR_PLAYLIST}" ]]; then
    sed '/^CHANNELS_SERVER_IP_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_IP"'/};${x;/^$/{s//CHANNELS_SERVER_IP_FOR_PLAYLIST='"$CHANNELS_SERVER_IP"'/;H};x}' -i /channels_buddy/.env
else
    sed '/^CHANNELS_SERVER_IP_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_IP_FOR_PLAYLIST"'/};${x;/^$/{s//CHANNELS_SERVER_IP_FOR_PLAYLIST='"$CHANNELS_SERVER_IP_FOR_PLAYLIST"'/;H};x}' -i /channels_buddy/.env
fi

if [[ -z "${CHANNELS_SERVER_PORT_FOR_PLAYLIST}" ]]; then
    sed '/^CHANNELS_SERVER_PORT_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_PORT"'/};${x;/^$/{s//CHANNELS_SERVER_PORT_FOR_PLAYLIST='"$CHANNELS_SERVER_PORT"'/;H};x}' -i /channels_buddy/.env
else
    sed '/^CHANNELS_SERVER_PORT_FOR_PLAYLIST=/{h;s/=.*/='"$CHANNELS_SERVER_PORT_FOR_PLAYLIST"'/};${x;/^$/{s//CHANNELS_SERVER_PORT_FOR_PLAYLIST='"$CHANNELS_SERVER_PORT_FOR_PLAYLIST"'/;H};x}' -i /channels_buddy/.env
fi

# Run database migrations
php artisan migrate --force

# Start supervisord
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf