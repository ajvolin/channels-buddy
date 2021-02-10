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
                            <div class="text-center text-primary my-2">
                                <b-spinner class="align-middle" />
                            </div>
                        </template>
                        <template #cell(id)="data">
                            <img v-if="getChannelAttribute(data.item,'logo')" :src="getChannelAttribute(data.item,'logo')" style="max-width: 60%; max-height: 50px; margin-bottom: 5px; filter: drop-shadow(lightgray 1px 1px 1px);" />
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
                            <b-button variant="link" aria-label="Customize channel" @click="data.toggleDetails">
                                <i class="las la-fw la-2x la-cog"></i>
                            </b-button>
                        </template>
                        <template #row-details="data">
                            <b-row>
                                <b-col sm="8" offset-sm="2">
                                    <b-card bg-variant="white" no-body>
                                        <template #header>
                                            <b-row>
                                                <b-col xs="9" class="my-auto">
                                                    <h4 class="mb-0">{{ data.item.name }}</h4>
                                                </b-col>
                                                <b-col xs="3">
                                                    <img
                                                        v-if="getChannelAttribute(data.item,'logo')"
                                                        :src="getChannelAttribute(data.item,'logo')"
                                                        class="img-fluid float-right"
                                                        style="max-height: 50px; filter: drop-shadow(darkgray 1px 1px 1px);"
                                                        alt="Channel logo" />
                                                </b-col>
                                            </b-row>
                                        </template>
                                        <b-card-img
                                            top
                                            v-if="getChannelAttribute(data.item,'channelArt')"
                                            :src="getChannelAttribute(data.item,'channelArt')"
                                            alt="Channel art">
                                        </b-card-img>
                                        <b-card-body>
                                            <h5>Channel Details</h5>
                                            <b-form-group
                                                label="Channel Name"
                                                label-for="channelName"
                                                :description="data.item.name">
                                                <b-form-input
                                                    id="channelName"
                                                    type="text"
                                                    placeholder="Channel name"
                                                    v-model.lazy="data.item.customizations.name" />
                                            </b-form-group>

                                            <b-form-group
                                                label="Call Sign"
                                                label-for="channelCallSign"
                                                :description="data.item.callSign || ''">
                                                <b-form-input
                                                    id="channelCallSign"
                                                    type="text"
                                                    placeholder="Call Sign"
                                                    v-model.lazy="data.item.customizations.callSign" />
                                            </b-form-group>

                                            <b-form-group
                                                label="Gracenote Station ID"
                                                label-for="channelStationId"
                                                :description="data.item.stationId || ''">
                                                <b-form-input
                                                    id="channelStationId"
                                                    type="text"
                                                    placeholder="Gracenote Station ID"
                                                    v-model.lazy="data.item.customizations.stationId" />
                                            </b-form-group>

                                            <b-form-group
                                                label="Category"
                                                label-for="channelCategory"
                                                :description="data.item.category || ''">
                                                <b-form-input
                                                    id="channelCategory"
                                                    type="text"
                                                    placeholder="Category"
                                                    v-model.lazy="data.item.customizations.category" />
                                            </b-form-group>
                                                
                                            <hr/>

                                            <h5>Channel Images</h5>
                                            <b-form-group
                                                label="Channel Logo"
                                                label-for="channelLogo"
                                                :description="data.item.logo || ''">
                                                <b-form-input
                                                    id="channelLogo"
                                                    type="url"
                                                    placeholder="URL to channel logo image"
                                                    v-model.lazy="data.item.customizations.logo" />
                                            </b-form-group>

                                            <b-form-group
                                                label="Channel Art"
                                                label-for="channelArt"
                                                :description="data.item.channelArt || ''">
                                                <b-form-input
                                                    id="channelArt"
                                                    type="url"
                                                    placeholder="URL to channel art image"
                                                    v-model.lazy="data.item.customizations.channelArt" />
                                            </b-form-group>

                                            <hr/>

                                            <h5>Guide Details</h5>
                                            <b-form-group
                                                label="Channel Title"
                                                label-for="channelTitle"
                                                :description="data.item.title || ''">
                                                <b-form-input
                                                    id="channelTitle"
                                                    type="text"
                                                    placeholder="Channel title (used for guide timeslot)"
                                                    v-model.lazy="data.item.customizations.title" />
                                            </b-form-group>

                                            <b-form-group
                                                label="Channel Description"
                                                label-for="channelDescr"
                                                :description="data.item.description || ''">
                                                <b-form-textarea
                                                    id="channelDescr"
                                                    rows="3"
                                                    max-rows="6"
                                                    placeholder="Channel description (used for guide timeslot)"
                                                    v-model.lazy="data.item.customizations.description" />
                                            </b-form-group>
                                        </b-card-body>
                                    </b-card>
                                </b-col>
                            </b-row>
                        </template>
                    </b-table>
                </b-col>
                <b-col xs="4" md="2" lg="2">
                    <div class="form-group">
                        <label for="channel_start_number">Starting Channel Number</label>
                        <b-form-input
                            id="channel_start_number"
                            class="text-center mx-auto"
                            type="number"
                            placeholder="Starting channel number"
                            v-model="channelRenumberStart"
                            number
                            debounce="300"
                            @update="renumberChannels" />
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
        channelStartNumber: Number
    },
    computed: {
        logo: function() {
            return this.channels
        }
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
            ],
            channelRenumberStart: null
        }
    },
    methods: {
        renumberChannels: function(value) {
            let currentNumber = value
            this.channels.forEach(function(o,i,a) {
                a[i].mapped_channel_number = currentNumber
                currentNumber++;
            })
        },
        getChannelAttribute(channel, attribute) {
            return channel.customizations[attribute] || channel[attribute];
        }
    },
    created() {
        this.channelRenumberStart = this.channelStartNumber
    },
    mounted() {
        this.dataLoading = true;
        axios.get(
            this.route(
                'channel-source.source.get-channels',
                { channelSource: this.source.source_name }
            )
        ).then(response => {
            this.channels = response.data
            console.log(this.channels)
        }).catch(error => {
            console.log(error)
            this.apiError = true
        }).finally(() => this.dataLoading = false);
    }
}
</script>