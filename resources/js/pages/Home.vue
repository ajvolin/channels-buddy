<template>
    <div class="row mt-4">
        <div class="col-xl-10 offset-xl-1">
            <div class="row">
                <div class="col-sm">
                    <h4>
                        Manage Channel Sources
                    </h4>
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <source-provider-card
                        title="Channels DVR"
                        subtitle="Remap channels and export M3U playlists and XMLTV guide data from your Channels DVR server"
                        noSourcesMessage="No Channels DVR Server Configured"
                        :sourceProvider="sources.channels_dvr"
                        sourceRoute="channels.source.map-ui" />
                </div>
                <div class="col-sm">
                    <source-provider-card
                        title="External Source Providers"
                        subtitle="Set channel numbers and export M3U playlists and XMLTV guide data from external source providers"
                        noSourcesMessage="No External Source Providers Configured"
                        :sourceProvider="sources.external"
                        sourceRoute="channel-source.source.map-ui" />
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <div class="col-sm">
                    <b-card bg-variant="light" no-body>
                        <b-card-body>
                            <b-card-title title-tag="h5">Help / Instructions</b-card-title>
                            <b-card-sub-title sub-title-text-variant="">Mapping Channel Numbers</b-card-sub-title>
                            <b-card-text>Leave the Channel Number field empty to use the original channel number. For external sources, you can use the Starting Channel Number field to automatically number all channels starting with the entered number.</b-card-text>
                            <hr/>
                            <b-card-sub-title sub-title-text-variant="">Channels DVR Sources - M3U Playlist Options</b-card-sub-title>
                            <b-card-text>Append <code>?max_number=CHANNEL_NUMBER</code> to the playlist URL to only include channel numbers up to and including the number provided.</b-card-text>
                            <hr/>
                            <b-card-sub-title sub-title-text-variant="">All Sources - XMLTV Guide Options</b-card-sub-title>
                            <b-card-text>Append <code>?days=</code> or <code>?hours=</code> or <code>?minutes=</code> or <code>?seconds=</code> to the XMLTV guide URL to export guide data for the provided duration.</b-card-text>
                        </b-card-body>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: `${this.title}`
        }
    },
    name: 'Home',
    props: {
        title: String,
        sources: Object
    },
    computed: {

    }
};
</script>