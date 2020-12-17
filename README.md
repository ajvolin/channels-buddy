# Channels DVR Channel Mapper

This PHP application converts the output from a [Channels](https://getchannels.com) DVR server to an M3U playlist and XMLTV EPG that can be used as an input for any IPTV software, including Emby (requires Emby Premiere) or even another Channels DVR instance.

Forked from [@crackers8199's](https://github.com/crackers8199) channels-dvr-mapper, thanks for the code!

## Setup
Run the container, substituting your Channels DVR server IP address and port.

    docker run -d \
      --restart unless-stopped \
      -p 8087:8087 \
      --name channel-mapper \
      -v channel_mapper:/channel_mapper \
      -e CHANNELS_SERVER_IP=[Your Channels DVR server IP address or hostname] \
      -e CHANNELS_SERVER_PORT=[Your Channels server DVR IP address or port] \
      ajvolin/channel-mapper

You can map channels, and get the M3U and EPG links for your sources at:
    http://127.0.0.1:8087