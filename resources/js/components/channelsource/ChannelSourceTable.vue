<template>
    <b-card bg-variant="white" no-body>
        <b-input-group class="my-3">
            <b-form-input
                id="search-input"
                v-model="search"
                type="text"
                placeholder="Search channels"
                debounce="300" />
            <b-input-group-append>
                <b-button :disabled="!search" @click="search = ''"><i class="las la-fw la-times"></i></b-button>
            </b-input-group-append>
        </b-input-group>
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
        <b-table
            hover
            head-variant="light"
            caption="List of channels"
            :busy="isBusy"
            :items="channels"
            :fields="channelTableFields"
            :filter="search"
            :filter-included-fields="searchOn"
            primary-key="id">
            <template #table-busy>
                <div class="text-center text-primary my-2">
                    <b-spinner class="align-middle" />
                </div>
            </template>
            <template #cell(id)="data">
                <img v-if="getChannelAttribute(data.item,'logo')" :src="getChannelAttribute(data.item,'logo')" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
                <div v-else class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ data.item.id }}</div>
                <div class="guide-channel-number">
                    <span v-if="data.item.number" class="badge badge-light" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ data.item.number }}</span>
                    <span style="font-size: 0.7em;">{{ getChannelAttribute(data.item,'name') }}</span>
                </div>
            </template>
            <template #cell(mapped_channel_number)="data">
                <input type="text" class="form-control text-center mx-auto map-channel" style="max-width: 250px;" v-model="data.item.mapped_channel_number" />
            </template>
            <template #cell(channel_enabled)="data">
                <b-form-checkbox v-model="data.item.channel_enabled" name="check-button" switch>
                    {{ data.item.channel_enabled ? "Enabled" : "Disabled" }}
                </b-form-checkbox>
            </template>
            <template #cell(channel_settings)="data">
                <b-button variant="link" aria-label="Customize channel" @click="data.toggleDetails">
                    <i class="las la-fw la-2x la-cog"></i>
                </b-button>
            </template>
            <template #row-details="data">
                <b-row>
                    <b-col sm="6" offset-sm="3">
                        <channel-source-channel-card
                            :channel="data"
                            :getChannelAttribute="getChannelAttribute"
                            :saveChannel="saveChannel" />
                    </b-col>
                </b-row>
            </template>
        </b-table>
    </b-card>
</template>

<script>
    export default {
        name: 'ChannelSourceTable',
        props: {
            channels: Array,
            isBusy: Boolean,
            saveChannel: Function
        },
        data() {
            return {
                channelTableFields: [
                    {
                        key: 'id',
                        label: 'Source Channel',
                        sortable: false,
                        class: 'text-left align-middle'
                    },
                    {
                        key: 'mapped_channel_number',
                        label: 'Channel Number',
                        sortable: true,
                        class: 'text-center align-middle'
                    },
                    {
                        key: 'channel_enabled',
                        label: 'Channel Status',
                        sortable: false,
                        class: 'text-center align-middle'
                    },
                    {
                        key: 'channel_settings',
                        label: '',
                        sortable: false,
                        class: 'text-center align-middle'
                    }
                ],
                search: null,
                searchOn: [
                    'number',
                    'name',
                    'mapped_channel_number',
                    'callSign',
                    'title',
                    'stationId'
                ]
            }
        },
        methods: {
            getChannelAttribute(channel, attribute) {
                return channel.customizations[attribute] || channel[attribute];
            }
        }
    }
</script>