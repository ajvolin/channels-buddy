@extends('layouts.main')

@section('content')
<div class="row mt-4">
    <div class="col-xl-10 offset-xl-1">
        <div class="row">
            <div class="col-sm">
                <h4>
                    Manage Channel Sources
                </h4>
                <hr />
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Channels DVR</h5>
                        <h6 class="card-subtitle text-muted">
                            Remap channels and export M3U playlists and XMLTV guide data from your Channels DVR server
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($channelsSources as $src => $srcName)
                        <a class="list-group-item list-group-item-action" href="{{ route('getChannelMapUI', ['source' => $src]) }}">{{$srcName}}</a>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-sm">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">External Source Providers</h5>
                        <h6 class="card-subtitle text-muted">
                            Set channel numbers and export M3U playlists and XMLTV guide data from external source providers
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($channelSources->getChannelSourceProviders() as $value)
                        <a class="list-group-item list-group-item-action" href="{{ route('getChannelSourceMapUI', ['channelSource' => $value->getSourceName()]) }}">{{ $value->getDisplayName() }}</a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-sm">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Help / Instructions</h5>
                        <h6 class="card-subtitle">
                            Mapping Channel Numbers
                        </h6>
                        <p class="card-text">
                            Leave the Channel Number field empty to use the original channel number. For external sources, you can use the Starting Channel Number field to automatically number all channels starting with the entered number.
                        </p>
                        <hr/>
                        <h6 class="card-subtitle">
                            Channels DVR Sources - M3U Playlist Options
                        </h6>
                        <p class="card-text">
                            Append <code>?max_number=CHANNEL_NUMBER</code> to the playlist URL to only include channel numbers up to and including the number provided.
                        </p>
                        <hr/>
                        <h6 class="card-subtitle">
                            All Sources - XMLTV Guide Options
                        </h6>
                        <p class="card-text">
                            Append <code>?days=</code> or <code>?hours=</code> or <code>?minutes=</code> or <code>?seconds=</code> to the XMLTV guide URL to export guide data for the provided duration.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection