#EXTM3U

@foreach($channels as $channel)
@include('channels.playlist.channel')
@endforeach
