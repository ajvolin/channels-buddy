<template>
    <b-modal
        v-if="channel"
        :id="channel.id"
        button-size="sm"
        centered
        content-class="shadow"
        header-bg-variant="light"
        lazy
        scrollable
        static
        title="Edit channel"
        @hide="handleHide">
        <template #modal-header>
            <h5 class="my-auto">{{ channel.name }}</h5>
            <img
                v-if="getChannelAttribute(channel,'logo')"
                :src="getChannelAttribute(channel,'logo')"
                class="img-fluid float-right"
                style="max-height: 50px; filter: drop-shadow(darkgray 1px 1px 1px);"
                alt="Channel logo" />
        </template>
        <b-card bg-variant="white" no-body>
            <b-card-img
                top
                v-if="getChannelAttribute(channel,'channelArt')"
                :src="getChannelAttribute(channel,'channelArt')"
                style="background: #000;"
                alt="Channel art">
            </b-card-img>
            <b-card-body>
                <h5 class="d-inline-block">Channel</h5>
                <b-form-checkbox
                    class="my-auto float-right d-inline-block"
                    v-model="channelStatus"
                    name="check-button"
                    switch />
                <b-form-group
                    label="Channel Name"
                    label-for="channelName"
                    :description="channel.name">
                    <b-form-input
                        id="channelName"
                        type="text"
                        placeholder="Channel name"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.name" />
                </b-form-group>

                <b-form-group
                    label="Call Sign"
                    label-for="channelCallSign"
                    :description="channel.callSign || ''">
                    <b-form-input
                        id="channelCallSign"
                        type="text"
                        placeholder="Call Sign"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.callSign" />
                </b-form-group>

                <b-form-group
                    label="Category"
                    label-for="channelCategory"
                    :description="channel.category || ''">
                    <b-form-input
                        id="channelCategory"
                        type="text"
                        placeholder="Category"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.category" />
                </b-form-group>
                    
                <hr/>

                <h5>Images</h5>
                <b-form-group
                    label="Channel Logo"
                    label-for="channelLogo"
                    :description="channel.logo || ''">
                    <b-form-input
                        id="channelLogo"
                        type="url"
                        placeholder="URL to channel logo image"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.logo" />
                </b-form-group>

                <b-form-group
                    label="Channel Art"
                    label-for="channelArt"
                    :description="channel.channelArt || ''">
                    <b-form-input
                        id="channelArt"
                        type="url"
                        placeholder="URL to channel art image"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.channelArt" />
                </b-form-group>

                <hr/>

                <h5>Guide Details</h5>
                <b-form-group
                    label="Channel Title"
                    label-for="channelTitle"
                    :description="channel.title || ''">
                    <b-form-input
                        id="channelTitle"
                        type="text"
                        placeholder="Channel title (used for guide timeslot)"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.title" />
                </b-form-group>

                <b-form-group
                    label="Channel Description"
                    label-for="channelDescr"
                    :description="channel.description || ''">
                    <b-form-textarea
                        id="channelDescr"
                        rows="3"
                        max-rows="6"
                        placeholder="Channel description (used for guide timeslot)"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.description" />
                </b-form-group>

                <b-form-group
                    label="Gracenote Station ID"
                    label-for="channelStationId"
                    :description="channel.stationId || ''">
                    <b-form-input
                        id="channelStationId"
                        type="text"
                        placeholder="Gracenote Station ID"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.customizations.stationId" />
                </b-form-group>
            </b-card-body>
        </b-card>
        <template #modal-footer>
            <div class="mr-auto">
                <b-button size="sm" variant="danger" @click="resetCustomizations()">Clear customizations</b-button>
            </div>
            <div class="float-right">
                <b-button size="sm" @click="cancelEdit()">Cancel</b-button>
                <b-button size="sm" variant="primary" @click="callSaveChannel()">
                    <b-spinner v-if="saving" small></b-spinner>
                    {{ saving ? 'Saving' : 'Save' }}
                </b-button>
            </div>
        </template>
    </b-modal>
</template>

<script>
    export default {
        name: 'ChannelSourceChannelModel',
        props: {
            channel: Object,
            getChannelAttribute: Function,
            saveChannel: Function
        },
        data() {
            return {
                saving: false,
                inputDebounce: 300,
                originalChannel: null,
                channelStatus: this.channel.channel_enabled
            }
        },
        mounted() {
            this.cloneOriginalChannel()
        },
        methods: {
            callSaveChannel() {
                this.saving = true
                this.channel.channel_enabled = this.channelStatus
                this.saveChannel(this.channel, () => {
                    this.saving = false
                    this.cloneOriginalChannel()
                    this.$bvModal.hide(this.channel.id)
                });
            },
            cancelEdit() {
                Object.keys(this.channel.customizations).forEach((key) => {
                    this.channel.customizations[key] = this.originalChannel.customizations[key]
                })
                this.channel.channel_enabled = this.originalChannel.channel_enabled
                this.channelStatus = this.channel.channel_enabled
                this.$bvModal.hide(this.channel.id)
            },
            confirmMsgBox(message, callback) {
                this.$bvModal.msgBoxConfirm(message, {
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'Yes',
                    centered: true,
                    hideHeaderClose: true,
                    noCloseOnBackdrop: true
                }).then(value => {
                    if (value) {
                        callback()
                    }
                }).catch(err => {
                    
                })
            },
            cloneOriginalChannel() {
                this.originalChannel = JSON.parse(JSON.stringify(this.channel))
            },
            handleHide(event) {
                if (event.trigger == 'esc' || event.trigger == 'backdrop') {
                    this.cancelEdit()
                }
            },
            resetCustomizations() {
                this.confirmMsgBox('Are you sure?', () => {
                    Object.keys(this.channel.customizations).forEach((key) => {
                        this.channel.customizations[key] = null
                    })
                })
            }
        }
    }
</script>