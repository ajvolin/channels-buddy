        <a href="#" class="dropdown-item channel-remap-select{{ $active ? ' active' : '' }}" data-channel-number="{{ $channel->number ?? '' }}" data-channel-callsign="{{ $channel->callSign ?? '' }}" data-channel-guide-name="{{ $channel->guideName ?? '' }}" data-channel-name="{{ $channel->name ?? '' }}" data-channel-station-id="{{ $channel->stationId ?? '' }}" role="button">
            <div class="row no-gutters align-middle" style="line-height: 1.1em;">
                <div class="mr-2 align-self-center col-2">
                    <span class="badge badge-{{ $active ? 'light' : 'primary' }}" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ $channel->number }}</span>
                </div>
                <div class="mx-2 col-2 d-flex align-items-center" style="min-height: 20px;">
                    @if(isset($channel->logo))
                    <img src="{{ $channel->logo }}" class="img-fluid m-auto">
                    @endif
                </div>
                <div class="align-self-center col" style="white-space: normal;">
                    <small>{{ $channel->callSign ?? $channel->name }}</small><br />
                    <small>{{ $channel->guideName ?? $channel->name ?? '' }}</small><br />
                    @if(isset($channel->stationId) && ctype_digit($channel->stationId))
                    <small>Station ID: {{ $channel->stationId }}</small>
                    @else
                    <br />
                    @endif
                </div>
            </div>
        </a>