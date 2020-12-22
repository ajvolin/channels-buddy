#EXTINF:0 channel-id="{!! $channel->id !!}" tvg-chno="{!! $channel->mappedChannelNum !!}" tvg-name="{!! $channel->id !!}"{!! isset($channel->logo) ? " tvg-logo=\"{$channel->logo}\"" : "" !!} tvc-guide-art="{!! $channel->channelArt !!}" tvc-guide-title="{!! $channel->name !!}" tvc-guide-description="{!! $channel->description !!}" group-title="{!! $channel->category !!}", {!! $channel->name !!}
{!! $channel->streamUrl !!}

