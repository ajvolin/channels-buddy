        <a href="#" class="dropdown-item channel-remap-select{{ $active ? ' active' : '' }}" data-channel-number="{{ $channel->GuideNumber ?? $channel->Number }}" data-channel-callsign="{{ $channel->CallSign ?? '' }}" data-channel-guide-name="{{ $channel->GuideName ?? '' }}" data-channel-name="{{ $channel->Name ?? '' }}" data-channel-station-id="{{ $channel->Station ?? '' }}" role="button">
            <div class="row no-gutters align-middle" style="line-height: 1.1em;">
                <div class="mr-2 align-self-center col-2">
                    <span class="badge badge-{{ $active ? 'light' : 'primary' }}" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ $channel->GuideNumber ?? $channel->Number }}</span>
                </div>
                <div class="mx-2 col-2 d-flex align-items-center" style="min-height: 20px;">
                    @if(isset($channel->Logo) || isset($channel->Image))
                    <img src="{{ $channel->Logo ?? $channel->Image }}" class="img-fluid m-auto">
                    @endif
                </div>
                <div class="align-self-center col" style="white-space: normal;">
                    <small>{{ $channel->CallSign ?? $channel->Name }}</small><br />
                    <small>{{ $channel->GuideName ?? $channel->Name ?? '' }}</small><br />
                    @if(isset($channel->Station) && ctype_digit($channel->Station))
                    <small>Station ID: {{ $channel->Station }}</small>
                    @else
                    <br />
                    @endif
                </div>
            </div>
        </a>