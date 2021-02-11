<template>
    <b-modal
        :id="channel.item.id"
        button-size="sm"
        centered
        content-class="shadow"
        header-bg-variant="light"
        hide-backdrop
        lazy
        no-close-on-backdrop
        no-close-on-esc
        scrollable
        static
        title="Edit channel"
        @ok="callSaveChannel">
        <template #modal-header>
            <h5 class="my-auto">{{ channel.item.name }}</h5>
            <img
                v-if="getChannelAttribute(channel.item,'logo')"
                :src="getChannelAttribute(channel.item,'logo')"
                class="img-fluid float-right"
                style="max-height: 50px; filter: drop-shadow(darkgray 1px 1px 1px);"
                alt="Channel logo" />
        </template>
        <b-card bg-variant="white" no-body>
            <b-card-img
                top
                v-if="getChannelAttribute(channel.item,'channelArt')"
                :src="getChannelAttribute(channel.item,'channelArt')"
                style="background: #000;"
                alt="Channel art">
            </b-card-img>
            <b-card-body>
                <h5>Channel Details</h5>
                <b-form-group
                    label="Channel Name"
                    label-for="channelName"
                    :description="channel.item.name">
                    <b-form-input
                        id="channelName"
                        type="text"
                        placeholder="Channel name"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.name" />
                </b-form-group>

                <b-form-group
                    label="Call Sign"
                    label-for="channelCallSign"
                    :description="channel.item.callSign || ''">
                    <b-form-input
                        id="channelCallSign"
                        type="text"
                        placeholder="Call Sign"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.callSign" />
                </b-form-group>

                <b-form-group
                    label="Gracenote Station ID"
                    label-for="channelStationId"
                    :description="channel.item.stationId || ''">
                    <b-form-input
                        id="channelStationId"
                        type="text"
                        placeholder="Gracenote Station ID"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.stationId" />
                </b-form-group>

                <b-form-group
                    label="Category"
                    label-for="channelCategory"
                    :description="channel.item.category || ''">
                    <b-form-input
                        id="channelCategory"
                        type="text"
                        placeholder="Category"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.category" />
                </b-form-group>
                    
                <hr/>

                <h5>Channel Images</h5>
                <b-form-group
                    label="Channel Logo"
                    label-for="channelLogo"
                    :description="channel.item.logo || ''">
                    <b-form-input
                        id="channelLogo"
                        type="url"
                        placeholder="URL to channel logo image"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.logo" />
                </b-form-group>

                <b-form-group
                    label="Channel Art"
                    label-for="channelArt"
                    :description="channel.item.channelArt || ''">
                    <b-form-input
                        id="channelArt"
                        type="url"
                        placeholder="URL to channel art image"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.channelArt" />
                </b-form-group>

                <hr/>

                <h5>Guide Details</h5>
                <b-form-group
                    label="Channel Title"
                    label-for="channelTitle"
                    :description="channel.item.title || ''">
                    <b-form-input
                        id="channelTitle"
                        type="text"
                        placeholder="Channel title (used for guide timeslot)"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.title" />
                </b-form-group>

                <b-form-group
                    label="Channel Description"
                    label-for="channelDescr"
                    :description="channel.item.description || ''">
                    <b-form-textarea
                        id="channelDescr"
                        rows="3"
                        max-rows="6"
                        placeholder="Channel description (used for guide timeslot)"
                        :debounce="inputDebounce"
                        v-model.lazy="channel.item.customizations.description" />
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
        name: 'ChannelSourceChannelCard',
        props: {
            channel: Object,
            getChannelAttribute: Function,
            saveChannel: Function
        },
        data() {
            return {
                saving: false,
                inputDebounce: 300,
                originalChannel: null
            }
        },
        mounted() {
            this.cloneOriginalChannel()
        },
        methods: {
            callSaveChannel() {
                this.saving = true
                this.saveChannel(this.channel.item, () => {
                    this.saving = false
                    this.cloneOriginalChannel()
                    this.$bvModal.hide(this.channel.item.id)
                });
            },
            cancelEdit() {
                Object.keys(this.channel.item.customizations).forEach((key) => {
                    this.channel.item.customizations[key] = this.originalChannel.customizations[key]
                })
                this.$bvModal.hide(this.channel.item.id)
            },
            cloneOriginalChannel() {
                this.originalChannel = JSON.parse(JSON.stringify(this.channel.item))
            },
            resetCustomizations() {
                Object.keys(this.channel.item.customizations).forEach((key) => {
                    this.channel.item.customizations[key] = null
                })
            }
        }
    }
</script>