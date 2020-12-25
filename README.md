# Channels Buddy

This PHP application generates M3U playlists and XMLTV guides with enhanced metadata from a [Channels](https://getchannels.com) DVR server and other Internet based sources that can be used as an input for any IPTV software, including Emby (requires Emby Premiere) or even another Channels DVR instance. Channel numbers can be mapped to a different number using a friendly UI.

Forked from [@crackers8199's](https://github.com/crackers8199) channels-dvr-mapper, thanks for the code!

## Setup
Run the container, substituting your Channels DVR server IP address and port.

    docker run -d \
      --restart unless-stopped \
      -p 8087:80 \
      --name channels-buddy \
      -v channels_buddy:/channels_buddy \
      -e CHANNELS_SERVER_IP=[Your Channels DVR server IP address or hostname] \
      -e CHANNELS_SERVER_PORT=[Your Channels server DVR IP address or port] \
      ajvolin/channels-buddy

You can map channels, and get the M3U and EPG links for your sources at:
    http://127.0.0.1:80