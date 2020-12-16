                        <tr id="channel-{{ $channel->GuideNumber }}" class="channel-row" data-channel-number="{{ $channel->GuideNumber }}" data-channel-callsign="{{ $channel->CallSign }}" data-channel-guide-name="{{ $channel->GuideName }}" data-channel-name="{{ $channel->Name }}" data-channel-remapped-number="{{ $channel->mapped_channel_number }}" data-channel-station-id="{{ $channel->Station ?? '' }}" data-channel-enabled="{{ $channel->channel_enabled }}">
                            <td style="padding: 10px; max-width: 125px; text-align: left;" class="align-middle px-3">
                                @if(isset($channel->Logo))
                                <img src="{{ $channel->Logo }}" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
                                @else
                                <div class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ $channel->GuideName }}</div>
                                @endif
                                <div class="guide-channel-number">
                                    <span class="badge badge-light" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ $channel->GuideNumber }}</span>
                                    <span style="font-size: 0.7em;">{{ $channel->CallSign }}</span>
                                </div>
                            </td>
                            <td style="padding: 10px; max-width: 300px;" class="align-middle channel-remap">
                                <input type="text" class="form-control text-center mx-auto map-channel" style="max-width: 250px;" name="channel[{{ $channel->GuideNumber }}][mapped]" value="{{ ($channel->GuideNumber != $channel->mapped_channel_number) ? $channel->mapped_channel_number : '' }}" data-toggle="dropdown" />
                                <div x-placement="bottom-end" class="dropdown-menu dropdown-menu-right channel-remap-search">
                                    <div class="current-channel-mapping">
                                        @include('channels.remap.dropdown.channel', ['active' => true])
                                    </div>
                                    <div role="separator" class="dropdown-divider"></div>
                                </div>
                            </td>
                            <td style="padding: 10px;" class="align-middle text-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input channel-status-checkbox" name="channel[{{ $channel->GuideNumber }}][enabled]" id="{{ md5($source.$channel->GuideNumber) }}" value="1" {{ $channel->channel_enabled ? "checked" : "" }}>
                                    <label class="custom-control-label" for="{{ md5($source.$channel->GuideNumber) }}">{{ $channel->channel_enabled ? "Enabled" : "Disabled" }}</label>
                                </div>
                            </td>
                        </tr>