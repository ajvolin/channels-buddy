@extends('layouts.main')

@section('content')
<div class="row mb-3">
    <div class="col-xs-8 col-md-10 col-lg-10">
        <h1>Pluto TV</h1>
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
            <input type="radio" id="channel_status_disabled" name="channel_status" class="custom-control-input" value="0" />
            <label class="custom-control-label" for="channel_status_disabled">Disabled Channels</label>
        </div>
    </div>
    <div class="col-xs-4 col-md-2 col-lg-2">
    </div>
</div>
<form action="{{ route('applyPlutoChannelMap') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-8 col-md-10 col-lg-10">
            <table class="table table-hover table-responsive" width="100%">
                <caption>List of channels</caption>
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-left" style="padding: 10px; max-width: 125px;">Pluto Channel</th>
                        <th scope="col" class="text-center" style="padding: 10px; max-width: 300px;">Mapped Channel Number</th>
                        <th scope="col" class="text-center" style="padding: 10px;">Channel Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($channels as $channel)
                    @include('pluto.channels.table.row')
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-xs-4 col-md-2 col-lg-2 align-left">
            <input type="submit" value="Save Channel Map" class="btn btn-primary" />
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        var searchChannels = function() {
            var search = encodeURI($("#search_channels").val());
            var channelStatus = $('input[name="channel_status"]:checked').val();

            var channelEnabledFilter = channelStatus !== '' ? '[data-channel-enabled="' + channelStatus + '"]' : '';

            var searchChannelNumber = [search !== '' ?
                '[data-channel-number*="' + search + '"]' :
                '', channelEnabledFilter
            ].filter(Boolean).join("");
            var searchChannelName = [search !== '' ?
                '[data-channel-name*="' + search.toUpperCase() + '"]' :
                '', channelEnabledFilter
            ].filter(Boolean).join("");
            var searchChannelRemappedNumber = [search !== '' ?
                '[data-channel-remapped-number*="' + search + '"]' :
                '', channelEnabledFilter
            ].filter(Boolean).join("");
            var searchChannelStationId = [search !== '' ?
                '[data-channel-station-id="' + search.toLowerCase() + '"]' :
                '', channelEnabledFilter
            ].filter(Boolean).join("");

            var filter = [
                searchChannelNumber,
                searchChannelName,
                searchChannelRemappedNumber,
                searchChannelStationId
            ].filter(Boolean).join(",");

            if (filter !== '') {
                $("tr.channel-row").hide()
                    .filter(filter)
                    .show();
            } else {
                $("tr.channel-row").show();
            }
        };

        $('input[type="checkbox"].channel-status-checkbox').on('click', function(e) {
            $(this).next().text($(this).next().text() == "Enabled" ? "Disabled" : "Enabled");
            $(this).parent().parent().parent().attr('data-channel-enabled', $(this).prop("checked") ? "1" : "0");
        });

        $('#search_channels, input[name="channel_status"]').on('change keyup', function(e) {
            searchChannels();
        });

        $('.map-channel').on('change', function(e) {
            var channelNumber = $(this).val() ||
                $(this).parent().parent().attr('data-channel-number');

            $(this).parent()
                .parent()
                .attr('data-channel-remapped-number', channelNumber);
        });
    });
</script>
@endsection