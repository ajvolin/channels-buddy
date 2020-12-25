<html>
<head>
    <title>{{ env('APP_NAME', 'Channels Buddy') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ URL::to('/') }}">Channels Buddy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ $channelsBackendUrl }}">Channels DVR Server</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    TV Sources
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach(config('channels.channelSources') as $key => $value)
                    <h6 class="dropdown-header">{{ $value['displayName'] }}</h6>
                    <a class="dropdown-item{{ isset($channelSource) && $channelSource == $key ? ' active' : '' }}" href="{{ route('getChannelSourceMapUI', ['channelSource' => $key]) }}">Channel Management</a>
                    <a class="dropdown-item" href="{{ route('channelSourcePlaylist', ['channelSource' => $key]) }}">M3U Playlist</a>
                    <a class="dropdown-item" href="{{ route('channelSourceXmlTv', ['channelSource' => $key]) }}">M3U XMLTV Guide</a>
                    @if(!$loop->last)
                    <div class="dropdown-divider"></div>
                    @endif
                    @endforeach
                </div>
            </li>
            @if(isset($sources))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Available Sources
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach($sources as $src => $srcName)
                        <a class="dropdown-item" href="{{ route('getChannelMapUI', ['source' => $src]) }}">{{ $srcName }}</a>
                    @endforeach
                </div>
            </li>
            @endif
            @if(isset($source))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Current Source: {{ $sources->get($source) }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @include('channels.includes.routeLinks')
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>

<div class="container" style="padding-top: 20px;">
    @yield('content')
</div>

</body>
</html>
