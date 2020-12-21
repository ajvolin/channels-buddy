#EXTINF:0 channel-id="{!! $channel->slug !!}" tvg-chno="{!! $channel->mappedChannelNum !!}" tvg-name="{!! $channel->slug !!}"{!! isset($channel->colorLogoPNG->path) ? " tvg-logo=\"{$channel->colorLogoPNG->path}\"" : "" !!} tvc-guide-art="{!! $channel->tvcArt !!}" tvc-guide-title="{!! $channel->name !!}" tvc-guide-description="{!! $channel->tvcGuideDescription !!}" group-title="{!! $channel->category !!}", {!! $channel->name !!}
{!! $channel->stream !!}

