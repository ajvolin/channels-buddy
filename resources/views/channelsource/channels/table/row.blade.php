                        <tr id="channel-{{ $channel->id }}" class="channel-row" data-channel-number="{{ $channel->number }}" data-channel-callsign="{{ $channel->callSign }}" data-channel-name="{{ strtoupper($channel->name) }}" data-channel-remapped-number="{{ $channel->mapped_channel_number }}" data-channel-station-id="{{ $channel->id }}" data-channel-enabled="{{ $channel->channel_enabled }}">
                            <td style="padding: 10px; max-width: 125px; text-align: left;" class="align-middle px-3">
                                @if(isset($channel->logo))
                                <img src="{{ $channel->logo }}" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
                                @else
                                <div class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ $channel->id }}</div>
                                @endif
                                <div class="guide-channel-number">
                                    @if($channel->number)
                                    <span class="badge badge-light" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ $channel->number }}</span>
                                    @endif
                                    <span style="font-size: 0.7em;">{{ $channel->name }}</span>
                                </div>
                            </td>
                            <td style="padding: 10px; max-width: 300px;" class="align-middle channel-remap">
                                <input type="text" class="form-control text-center mx-auto map-channel" style="max-width: 250px;" name="channel[{{ $channel->id }}][mapped]" value="{{ ($channel->number != $channel->mapped_channel_number) ? $channel->mapped_channel_number : '' }}" />
                                <input type="hidden" name="channel[{{ $channel->id }}][number]" value="{{ $channel->number }}" />
                            </td>
                            <td style="padding: 10px;" class="align-middle text-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input channel-status-checkbox" name="channel[{{ $channel->id }}][enabled]" id="{{ md5($channel->id) }}" value="1" {{ $channel->channel_enabled ? "checked" : "" }}>
                                    <label class="custom-control-label" for="{{ md5($channel->id) }}">{{ $channel->channel_enabled ? "Enabled" : "Disabled" }}</label>
                                </div>
                            </td>
                        </tr>