#EXTM3U

@foreach($channels as $channel)
@include('channelsource.playlist.channel')
@endforeach
