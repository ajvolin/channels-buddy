<template>
    <b-row class="mt-4">
        <b-col xl="10" offset-xl="1">
            <b-row class="mb-3">
                <b-col xs="8" md="10" lg="10">
                    <h1>{{ source.display_name }}</h1>
                    <b-card  bg-variant="white">
                        <b-list-group class="list-unstyled">
                            <li>
                                <small class="text-muted">M3U Playlist URL: </small> <code class="user-select-all">{{ route('channel-source.source.playlist', { channelSource: source.source_name }) }}</code>
                            </li>
                            <li v-if="source.provides_guide">
                                <small class="text-muted">XMLTV Guide URL: </small><code class="user-select-all">{{ route('channel-source.source.guide', { channelSource: source.source_name }) }}</code>
                            </li>
                        </b-list-group>
                    </b-card>
                </b-col>
            </b-row>
            <b-row class="mb-3">
                <b-col xs="8" md="10" lg="10">
                    <channel-source-table
                        :channels="channels"
                        :isBusy="dataLoading"
                        :saveChannel="saveChannel" />
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
                    <input type="submit" value="Save Channel Map" @click="saveChannels" class="btn btn-primary" />
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
        data() {
            return {
                apiError: false,
                dataLoading: false,
                channels: [],
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
            saveChannel: function(channel) {
                axios.put(
                    this.route(
                        'channel-source.source.update-channel',
                        { channelSource: this.source.source_name }
                    ), { channel: channel }
                ).then(response => {
                    console.log('Updated channel ' + this.source.display_name + ': ' + channel.id)
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                })
            },
            saveChannels: function() {
                axios.put(
                    this.route(
                        'channel-source.source.update-channels',
                        { channelSource: this.source.source_name }
                    ), { channels: this.channels }
                ).then(response => {
                    console.log('Updated channels for ' + this.source.display_name)
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                })
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
                // console.log(this.channels)
            }).catch(error => {
                console.log(error)
                this.apiError = true
            }).finally(() => this.dataLoading = false);
        }
    }
</script>