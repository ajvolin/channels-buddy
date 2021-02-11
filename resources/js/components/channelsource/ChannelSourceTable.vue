<template>
    <div>
        <b-input-group class="mb-3">
            <b-form-input
                id="search-input"
                v-model="channelSearch"
                type="text"
                placeholder="Search channels"
                :disabled="isBusy"
                debounce="300" />
                <b-form-select
                    :disabled="isBusy"
                    :options="channelStatusFilterOptions"
                    v-model="channelStatusFilterSelected"
                    style="max-width: 200px;" />
            <b-input-group-append>
                <b-button
                    :disabled="!channelSearch && !channelStatusFilterSelected"
                    @click="channelSearch = ''; channelStatusFilterSelected = null">
                    <i class="las la-fw la-times-circle"></i>
                </b-button>
            </b-input-group-append>
        </b-input-group>
        <b-table
            hover
            head-variant="light"
            caption="List of channels"
            :busy="isBusy"
            :items="channels"
            :fields="channelTableFields"
            :filter="channelFilter"
            :filter-function="filterChannelsTable"
            :filter-included-fields="searchOn"
            primary-key="id">
            <template #table-busy>
                <div class="text-center text-primary my-2">
                    <b-spinner class="align-middle" />
                </div>
            </template>
            <template #cell(name)="data">
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
                <b-form-checkbox
                    v-model="data.item.channel_enabled"
                    name="check-button"
                    switch>
                    {{ data.item.channel_enabled ? "Enabled" : "Disabled" }}
                </b-form-checkbox>
            </template>
            <template #cell(channel_settings)="data">
                <b-button block class="text-center" variant="link" aria-label="Customize channel" @click="$bvModal.show(data.item.id)">
                    <i class="las la-fw la-2x la-cog"></i>
                </b-button>
                <channel-source-channel-modal
                    :channel="data.item"
                    :getChannelAttribute="getChannelAttribute"
                    :saveChannel="saveChannel" />
            </template>
        </b-table>
    </div>
</template>

<script>
    export default {
        name: 'ChannelSourceTable',
        props: {
            channels: Array,
            isBusy: Boolean,
            saveChannel: Function
        },
        computed: {
            channelFilter: function() {
                if ((this.channelSearch == '' ||
                        this.channelSearch === null) &&
                        this.channelStatusFilterSelected ===  null){
                    return null
                }
                return [
                    (this.channelSearch !== null && this.channelSearch != '') ? this.channelSearch : null,
                    this.channelStatusFilterSelected
                ]
            }
        },
        data() {
            return {
                channelSearch: null,
                channelStatusFilterSelected: null,
                channelStatusFilterOptions: [
                    { value: null, text: 'All Channels' },
                    { value: true, text: 'Enabled Channels' },
                    { value: false, text: 'Disabled Channels' }
                ],
                channelTableFields: [
                    {
                        key: 'name',
                        label: 'Source Channel',
                        sortable: false,
                        class: 'text-left align-middle'
                    },
                    {
                        key: 'mapped_channel_number',
                        label: 'Channel Number',
                        sortable: false,
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
                        class: 'align-middle'
                    }
                ],
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
            filterChannelsTable: function(row, filter) {
                const searchValues = [];
                this.searchOn.forEach((k) => {
                    if (row[k]) {
                        searchValues.push(row[k])
                    }
                })
                
                const searchMatch = 
                    (filter[0] !== null) ? searchValues
                        .join(' ')
                        .toLowerCase()
                        .includes(
                            filter[0].toLowerCase()
                        ) : false

                if (filter[0] !== null && filter[1] !== null){
                    return searchMatch && 
                        row.channel_enabled == filter[1];
                }
                else {
                    return searchMatch ||
                        row.channel_enabled == filter[1];
                }
            },
            getChannelAttribute(channel, attribute) {
                return channel.customizations[attribute] || channel[attribute];
            }
        }
    }
</script>