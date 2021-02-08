<template>
    <tr :id="'channel-'+channel.id" class="channel-row" :data-channel-number="channel.number" :data-channel-callsign="channel.callSign" :data-channel-name="channel.name.toUpperCase()" :data-channel-remapped-number="channel.mapped_channel_number" :data-channel-station-id="channel.id" :data-channel-enabled="channel.channel_enabled">
        <td style="padding: 10px; max-width: 125px; text-align: left;" class="align-middle px-3">
            <img v-if="channel.logo" :src="channel.logo" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
            <div v-else class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ channel.id }}</div>
            <div class="guide-channel-number">
                <span v-if="channel.number" class="badge badge-light" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ channel.number }}</span>
                <span style="font-size: 0.7em;">{{ channel.name }}</span>
            </div>
        </td>
        <td style="padding: 10px; max-width: 300px;" class="align-middle channel-remap">
            <input type="text" class="form-control text-center mx-auto map-channel" style="max-width: 250px;" :name="'channel[' + channel.id + '][mapped]'" :value="channel.number != channel.mapped_channel_number ? channel.mapped_channel_number : ''" />
            <input type="hidden" :name="'channel[' + channel.id + '][number]'" :value="channel.number" />
        </td>
        <td style="padding: 10px;" class="align-middle text-center">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input channel-status-checkbox" :name="'channel[' + channel.id + '][enabled]'" :id="channel.id" value="1" :checked="channel.channel_enabled" />
                <label class="custom-control-label" :for="channel.id">{{ channel.channel_enabled ? "Enabled" :"Disabled" }}</label>
            </div>
        </td>
        <td style="padding: 10px;" class="align-middle text-center">
            <a href="#" class="open-channel-settings" aria-label="Customize channel" title="Customize channel" :data-channel-name="channel.name" data-toggle="modal" data-target="#channel-settings"><i class="las la-fw la-2x la-cog"></i></a>
            <input type="hidden" class="custom-logo-input" :name="'channel[' + channel.id + '][custom_logo]'" :value="channel.custom_logo" />
            <input type="hidden" class="custom-channel-art-input" :name="'channel[' + channel.id + '][custom_channel_art]'" :value="channel.custom_channel_art" />
        </td>
    </tr>
</template>

<script>
export default {
    name: 'ChannelSourceTableRow',
    props: {
        channel: Object
    }
}
</script>