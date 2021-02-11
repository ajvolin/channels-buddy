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
                        <b-form-input
                            id="channel_start_number"
                            class="text-center mx-auto"
                            type="number"
                            placeholder="Starting channel number"
                            v-model="channelRenumberStart"
                            min="1"
                            number
                            debounce="300"
                            :disabled="saving || dataLoading"
                            @update="renumberChannels" />
                            <label for="channel_start_number">Starting Channel Number</label>
                        <small>Enter a starting number to automatically re-number the channels</small>
                    </div>
                    <b-button block size="sm" variant="primary" @click="saveChannels" :disabled="saving || dataLoading">
                        <b-spinner v-if="saving" small></b-spinner>
                        {{ saving ? 'Saving Channel Map' : 'Save Channel Map' }}
                    </b-button>
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
                channelRenumberStart: null,
                saving: false
            }
        },
        methods: {
            makeToast: function(error, title, message) {
                this.$bvToast.toast(message, {
                    title: title,
                    autoHideDelay: 5000,
                    appendToast: true,
                    solid: true,
                    toaster: 'b-toaster-top-right',
                    variant: error ? 'danger' : 'success',
                })
            },
            renumberChannels: function(value) {
                let currentNumber = value
                this.channels.forEach(function(o,i,a) {
                    a[i].mapped_channel_number = currentNumber
                    currentNumber++;
                })
            },
            saveChannel: function(channel, callback) {
                axios.put(
                    this.route(
                        'channel-source.source.update-channel',
                        { channelSource: this.source.source_name }
                    ), { channel: channel }
                ).then(response => {
                    console.log('Updated channel ' + this.source.display_name + ': ' + channel.name)
                    this.makeToast(false,
                        'Success',
                        response.data.message
                    )
                }).catch(error => {
                    console.log(error)
                    this.makeToast(true,
                        'Error',
                        'Unable to save ' + channel.name + '.'
                    )
                }).finally(() => {
                    if (callback !== undefined) {
                        callback()
                    }
                })
            },
            saveChannels: function() {
                this.saving = true
                axios.put(
                    this.route(
                        'channel-source.source.update-channels',
                        { channelSource: this.source.source_name }
                    ), {
                        channelStartNumber: this.channelRenumberStart,
                        channels: this.channels
                    }
                ).then(response => {
                    console.log('Updated channels for ' + this.source.display_name)
                    this.makeToast(false,
                        'Success',
                        response.data.message
                    )
                }).catch(error => {
                    console.log(error)
                    this.makeToast(true,
                        'Error',
                        'Unable to save channels.'
                    )
                }).finally(() => { this.saving = false })
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
            }).catch(error => {
                console.log(error)
                this.apiError = true
            }).finally(() => this.dataLoading = false);
        }
    }
</script>