<template>
    <b-row class="mt-4">
        <b-col xl="10" offset-xl="1">
            <b-row class="mb-3">
                <b-col xs="8" md="10" lg="10">
                    <h1>{{ source.display_name }}</h1>
                    <b-card  bg-variant="white">
                        <b-card-text>
                            <small class="text-muted">M3U Playlist URL:</small> <code>{{ route('channel-source.source.playlist', { channelSource: source.source_name }) }}</code>
                        </b-card-text>
                        <b-card-text v-if="source.provides_guide">
                            <small class="text-muted">XMLTV Guide URL: </small><code>{{ route('channel-source.source.guide', { channelSource: source.source_name }) }}</code>
                        </b-card-text>
                    </b-card>
                    
                    <b-input-group class="my-3">
                        <b-form-input
                            id="search-input"
                            v-model="search"
                            type="search"
                            placeholder="Search channels" />
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
                </b-col>
            </b-row>
            <b-row class="mb-3">
                <b-col xs="8" md="10" lg="10">
                    <b-table
                        hover
                        head-variant="light"
                        caption="List of channels"
                        :busy="dataLoading"
                        :items="channels"
                        :fields="channelTableFields"
                        :filter="search"
                        :filter-included-fields="searchOn"
                        primary-key="id"
                        >
                        <template #table-busy>
                            <div class="text-center text-success my-2">
                                <b-spinner class="align-middle"></b-spinner>
                            </div>
                        </template>
                        <template #cell(id)="data">
                            <img v-if="data.item.logo" :src="data.item.logo" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
                            <div v-else class="guide-channel-name" style="font-size: 0.9em; padding: 19px 0;">{{ data.item.id }}</div>
                            <div class="guide-channel-number">
                                <span v-if="data.item.number" class="badge badge-light" style="min-width: 4em; display: inline-block; margin-right: 1em;">{{ data.item.number }}</span>
                                <span style="font-size: 0.7em;">{{ data.item.name }}</span>
                            </div>
                        </template>
                        <template #cell(mapped_channel_number)="data">
                            <input type="text" class="form-control text-center mx-auto map-channel" style="max-width: 250px;" v-model="data.item.mapped_channel_number" />
                        </template>
                        <template #cell(channel_enabled)="data">
                            <b-form-checkbox v-model="data.item.channel_enabled" name="check-button" switch>
                                {{ data.item.channel_enabled ? "Enabled" :"Disabled" }}
                            </b-form-checkbox>
                        </template>
                        <template #cell(channel_settings)="data">
                            <a href="#" class="open-channel-settings" aria-label="Customize channel" title="Customize channel" :data-channel-name="data.item.name" data-toggle="modal" data-target="#channel-settings"><i class="las la-fw la-2x la-cog"></i></a>
                        </template>
                    </b-table>
                </b-col>
                <b-col xs="4" md="2" lg="2">
                    <div class="form-group">
                        <label for="channel_start_number">Starting Channel Number</label>
                        <input type="text" class="form-control text-center mx-auto" id="channel_start_number" name="channel_start_number" v-model.lazy="channelStartNumber" @change="renumberChannels($event)" />
                        <small>Enter a starting number to automatically re-number the channels</small>
                    </div>
                    <input type="submit" value="Save Channel Map" class="btn btn-primary" />
                    <span id="duplicateChannelErrorMsg" class="text-danger" style="display: none;">Duplicate channel numbers detected.</span>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: `${this.title}`
        }
    },
    name: 'ChannelSourceMap',
    props: {
        title: String,
        source: Object,
        channelStartNumber: String
    },
    data() {
        return {
            apiError: false,
            dataLoading: false,
            channels: [],
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
        renumberChannels: function(evt) {
            let currentNumber = evt.target.value
            this.channels.forEach(function(o,i,a) {
                a[i].mapped_channel_number = currentNumber;
                currentNumber++;
            })
        }
    },
    mounted () {
        this.dataLoading = true;
        axios
        .get(
            this.route(
                'channel-source.source.get-channels',
                { channelSource: this.source.source_name }
            )
        ).then(response => {
            this.channels = response.data
        }).catch(error => {
            console.log(error)
            this.apiError = true
        }).finally(() => this.dataLoading = false);
    }
}
</script>