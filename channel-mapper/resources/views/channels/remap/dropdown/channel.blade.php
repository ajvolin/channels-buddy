        <a href="#" class="dropdown-item channel-remap-select {{ $active ? 'active' : '' }}" data-channel-number="{{ $channel->GuideNumber }}" data-channel-search="{{ $channel->GuideNumber }} {{ Str::upper($channel->CallSign) }} {{ Str::upper($channel->GuideName) }} {{ Str::upper($channel->Name) }}" role="button">
            <div class="row no-gutters align-middle" style="line-height: 1.1em;">
                <div class="mr-2 align-self-center col-2">
                    <span class="badge badge-{{ $active ? 'light' : 'primary' }}" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ $channel->GuideNumber }}</span>
                </div>
                <div class="mx-2 col-2 d-flex align-items-center" style="min-height: 20px;">
                    @if(isset($channel->Logo))
                    <img src="{{ $channel->Logo }}" class="img-fluid m-auto">
                    @endif
                </div>
                <div class="align-self-center col" style="white-space: normal;">
                    <small>{{ $channel->CallSign }}</small><br/>
                    <small>{{ $channel->GuideName }}{{ $channel->Name !== $channel->GuideName ? " | " . $channel->Name : "" }}</small><br/>
                    @if(isset($channel->Station))
                    <small>Station ID: {{ $channel->Station }}</small>
                    @else
                    <br/>
                    @endif
                </div>
            </div>
        </a>