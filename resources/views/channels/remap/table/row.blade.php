                        <tr id="channel-{{ $channel->id }}" class="channel-row" data-channel-number="{{ $channel->number }}" data-channel-callsign="{{ $channel->callSign }}" data-channel-guide-name="{{ $channel->guideName }}" data-channel-name="{{ $channel->name }}" data-channel-remapped-number="{{ $channel->mapped_channel_number }}" data-channel-station-id="{{ $channel->stationId ?? '' }}" data-channel-enabled="{{ $channel->channel_enabled }}">
                            <td style="padding: 10px; max-width: 125px; text-align: left;" class="align-middle px-3">
                                @if(isset($channel->logo))
                                <img src="{{ $channel->logo }}" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
                                @else
                                <div class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ $channel->guideName }}</div>
                                @endif
                                <div class="guide-channel-number">
                                    <span class="badge badge-light" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ $channel->number }}</span>
                                    <span style="font-size: 0.7em;">{{ $channel->callSign }}</span>
                                </div>
                            </td>
                            <td style="padding: 10px; max-width: 300px;" class="align-middle channel-remap">
                                <input type="text" class="form-control text-center mx-auto map-channel" style="max-width: 250px;" name="channel[{{ $channel->number }}][mapped]" value="{{ ($channel->number != $channel->mapped_channel_number) ? $channel->mapped_channel_number : '' }}" data-toggle="dropdown" />
                                <div class="dropdown-menu dropdown-menu-right channel-remap-search">
                                    <div class="current-channel-mapping">
                                        @include('channels.remap.dropdown.channel', ['active' => true])
                                    </div>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <div class="channel-select-list-match"></div>
                                </div>
                            </td>
                            <td style="padding: 10px;" class="align-middle text-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input channel-status-checkbox" name="channel[{{ $channel->number }}][enabled]" id="{{ md5($source.$channel->id) }}" value="1" {{ $channel->channel_enabled ? "checked" : "" }}>
                                    <label class="custom-control-label" for="{{ md5($source.$channel->id) }}">{{ $channel->channel_enabled ? "Enabled" : "Disabled" }}</label>
                                </div>
                            </td>
                            <td style="padding: 10px;" class="align-middle text-center">
                                <a href="#" class="open-channel-settings" aria-label="Customize channel" title="Customize channel" data-channel-name="{{ $channel->name }}" data-toggle="modal" data-target="#channel-settings"><i class="las la-fw la-2x la-cog"></i></a>
                                <input type="hidden" class="custom-logo-input" name="channel[{{ $channel->number }}][custom_logo]" value="{{ $channel->custom_logo }}" />
                                <input type="hidden" class="custom-channel-art-input" name="channel[{{ $channel->number }}][custom_channel_art]" value="{{ $channel->custom_channel_art }}" />
                            </td>
                        </tr>