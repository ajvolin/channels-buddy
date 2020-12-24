#EXTM3U

@foreach($channels as $channel)
@include('playlist.channel')
@endforeach
