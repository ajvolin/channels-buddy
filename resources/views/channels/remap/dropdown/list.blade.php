    <div id="channel-select-list-container">
        <div id="channel-select-list">
        @foreach($allChannels as $channel)
        @include('channels.remap.dropdown.channel', ['active' => false])
        @endforeach
        </div>
    </div>