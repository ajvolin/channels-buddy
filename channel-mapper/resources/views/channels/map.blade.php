@extends('layouts.main')

@section('content')

    <div class="row mb-3">
        <div class="col-xs-8 col-md-10 col-lg-10">
            <h1>{{ $sources->get($source) }}</h1>
            <input type="text" class="form-control my-3" id="search_channels" name="search_channels" placeholder="Search channels" />
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="channel_status_any" name="channel_status" class="custom-control-input" value="" checked />
                <label class="custom-control-label" for="channel_status_any">All Channels</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="channel_status_enabled" name="channel_status" class="custom-control-input" value="1" />
                <label class="custom-control-label" for="channel_status_enabled">Enabled Channels</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="channel_status_disabled" name="channel_status" class="custom-control-input" value="0"  />
                <label class="custom-control-label" for="channel_status_disabled">Disabled Channels</label>
            </div>
        </div>
        <div class="col-xs-4 col-md-2 col-lg-2">
        </div>
    </div>
    <form action="{{ route('applyChannelMap', ['source' => $source]) }}" method="POST">
    @csrf
        <div class="row">
            <div class="col-xs-8 col-md-10 col-lg-10">
                <table class="table table-striped table-hover table-responsive" width="100%">
                    <caption>List of channels</caption>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-left" style="padding: 10px; max-width: 125px;">DVR Channel</th>
                            <th scope="col" class="text-center" style="padding: 10px; max-width: 300px;">Re-Mapped Channel Number</th>
                            <th scope="col" class="text-center" style="padding: 10px;">Channel Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sourceChannels as $channel)
                        <tr id="channel-{{ $channel->GuideNumber }}" class="channel-row" data-channel-number="{{ $channel->GuideNumber }}" data-channel-callsign="{{ $channel->CallSign }}" data-channel-guide-name="{{ $channel->GuideName }}" data-channel-name="{{ $channel->Name }}" data-channel-remapped-number="{{ $channel->mapped_channel_number }}" data-channel-station-id="{{ $channel->Station ?? '' }}" data-channel-enabled="{{ $channel->channel_enabled }}" data-channel-search="{{ $channel->GuideNumber }} {{ Str::upper($channel->CallSign) }} {{ Str::upper($channel->GuideName) }} {{ Str::upper($channel->Name) }} {{ $channel->mapped_channel_number }}">
                            <td style="padding: 10px; max-width: 125px; text-align: left;" class="align-middle px-3">
                                @if(isset($channel->Logo))
                                <img src="{{ $channel->Logo }}" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
                                @else
                                <div class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ $channel->GuideName }}</div>
                                @endif
                                <div class="guide-channel-number" style="font-size: 0.7em;">{{ $channel->GuideNumber }} - {{ $channel->CallSign }}</div>
                            </td>
                            <td style="padding: 10px; max-width: 300px;" class="text-center align-middle channel-remap">
                                <div class="dropdown">
                                    <input type="text" class="form-control text-center mx-auto" style="max-width: 250px;" name="channel[{{ $channel->GuideNumber }}][mapped]" value="{{ ($channel->GuideNumber != $channel->mapped_channel_number) ? $channel->mapped_channel_number : '' }}" />
                                    <div class="dropdown-menu" aria-label="Channel search list dropdown">
                                        
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 10px;" class="align-middle text-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="channel[{{ $channel->GuideNumber }}][enabled]" id="{{ md5($source.$channel->GuideNumber) }}" value="1" {{ $channel->channel_enabled ? "checked" : "" }}>
                                    <label class="custom-control-label" for="{{ md5($source.$channel->GuideNumber) }}">{{ $channel->channel_enabled ? "Enabled" : "Disabled" }}</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-4 col-md-2 col-lg-2 align-left" >
                <input type="submit" value="Save Channel Map" class="btn btn-primary" />
            </div>
        </div>
    </form>
<script>
    function searchChannels() {
        var search = $("#search_channels").val();
        var channel_status = $('input[name="channel_status"]:checked').val();
        
        var search_filter = search !== '' ? '[data-channel-search*="' + search.toUpperCase() + '"]' : '';
        var channel_filter = channel_status !== '' ? '[data-channel-enabled=' + channel_status + ']' : '';

        var filter = [search_filter, channel_filter].filter(Boolean).join("");

        if (filter !== '') {
            $("tr.channel-row").hide()
                .filter(filter)
                .show();
        }
        else {
            $("tr.channel-row").show();
        }
    }
    $('input[type="checkbox"]').on('click', function(e){
        $(this).next().text($(this).next().text() == "Enabled" ? "Disabled" : "Enabled");
    });
    $('#search_channels, input[name="channel_status"]').on('change keyup', function(e){
        searchChannels();
    });
</script>
@endsection
