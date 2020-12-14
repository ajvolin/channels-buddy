@extends('layouts.main')

@section('content')
    <style>
        #channel-select-list-container {
            display: none;
        }
        .channel-remap-search {
            min-height: 350px;
            max-height: 350px;
            min-width: 320px;
            max-width: 320px;
            overflow-y: scroll;
        }
        .channel-remap-select.row {
            min-height: 51px;
        }
        .channel-remap-select img {
            max-width: auto;
            height: 30px;

        }
    </style>
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
                        @include('channels.remap.table.row')
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-4 col-md-2 col-lg-2 align-left" >
                <input type="submit" value="Save Channel Map" class="btn btn-primary" />
            </div>
        </div>
    </form>
    @include('channels.remap.dropdown.list')
<script>
    function searchChannels() {
        var search = $("#search_channels").val();
        var channelStatus = $('input[name="channel_status"]:checked').val();
        
        var searchFilter = search !== '' ? '[data-channel-search*="' + search.toUpperCase() + '"]' : '';
        var channelFilter = channelStatus !== '' ? '[data-channel-enabled=' + channelStatus + ']' : '';

        var filter = [searchFilter, channelFilter].filter(Boolean).join("");

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

    $('body').on('click', '.channel-remap-select', function(e){
        e.preventDefault();
        $(this).parent().parent().siblings("input").val($(this).data('channel-number'));
        $(this).parent().parent().siblings("input").trigger("change");
    });

    $('.channel-remap').on('show.bs.dropdown', function () {
        var channelSelectList = $("#channel-select-list");
        var currentRemappedChannelNumber = $(this).parents("tr.channel-row").data('channel-remapped-number') || $(this).parents("tr.channel-row").data('channel-number');
        
        $(this).children(".channel-remap-search").append(channelSelectList);
        $("#channel-select-list a").hide()
            .filter("[data-channel-number!=" + currentRemappedChannelNumber + "]")
            .show();
    });

    $('.map-channel').on('keyup', function(e){
        var search = $(this).val();
        var searchFilter = search !== '' ? '[data-channel-search*="' + search.toUpperCase() + '"]' : '';

        if (searchFilter !== '') {
            $("#channel-select-list a").hide()
                .filter(searchFilter)
                .show();
        }
        else {
            $("#channel-select-list a").show();
        }
    });

    $('.map-channel').on('change', function(e){
        var channelNumber = $(this).val() || $(this).parents().find("tr.channel-row").data('channel-number');

        $(this).siblings(".channel-remap-search")
            .find(".current-channel-mapping a.active.channel-remap-select")
            .data('channel-number', channelNumber);
        
        $(this).siblings(".channel-remap-search")
            .find(".current-channel-mapping a.active.channel-remap-select .badge")
            .text(channelNumber);

        $(this).parents()
            .find("tr")
            .data('channel-remapped-number', channelNumber);
    });
</script>
@endsection
