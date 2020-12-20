#EXTM3U

@foreach($channels as $channel)
@include('pluto.playlist.channel')
@endforeach
