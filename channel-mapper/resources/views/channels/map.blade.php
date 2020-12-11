@extends('layouts.main')

@section('content')

<form action="{{ route('applyChannelMap', ['source' => $source]) }}" method="POST">
@csrf

    <div class="row">
        <div class="col-xs-8 col-md-10 col-lg-10">
            <h1>{{ $sources->get($source) }}</h1>
        </div>
        <div class="col-xs-4 col-md-2 col-lg-2">

        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-md-10 col-lg-10">
            <table class="table table-striped table-hover table-responsive" width="100%">
                <caption>List of channels</caption>
                <thead class="thead-light">
                    <tr class="text-center">
                        <th scope="col" style="padding: 10px; max-width: 200px;">DVR Channel</th>
                        <th scope="col" style="padding: 10px; max-width: 300px;">Re-Mapped Channel Number</th>
                        <th scope="col" style="padding: 10px;">Channel Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($channels as $channel)
                    <tr>
                        <td style="padding: 10px; max-width: 200px; text-align: center;" class="align-middle">
                            @if(isset($channel->Logo))
                            <img src="{{ $channel->Logo }}" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
                            @else
                            <div class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ $channel->GuideName }}</div>
                            @endif
                            <div class="guide-channel-number" style="font-size: 0.7em;">{{ $channel->GuideNumber }}</div>
                        </td>
                        <td style="padding: 10px; max-width: 300px;" class="text-center align-middle">
                            <input type="text" class="form-control text-center mx-auto" style="width: 100px;" name="channel[{{ $channel->GuideNumber }}][mapped]" value="{{ ($channel->GuideNumber != $channel->mapped_channel_number) ? $channel->mapped_channel_number : '' }}" />
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
    $('input[type="checkbox"]').on('click', function(e){
        $(this).next().text($(this).next().text() == "Enabled" ? "Disabled" : "Enabled");
    })
</script>
@endsection
