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
                    <b-card bg-variant="light" no-body>
                        <b-card-body>
                            <b-card-title title-tag="h5">Channels DVR</b-card-title>
                            <b-card-sub-title>Remap channels and export M3U playlists and XMLTV guide data from your Channels DVR server</b-card-sub-title>
                        </b-card-body>
                        <b-list-group flush v-if="hasSources(channels_dvr)">
                            <b-list-group-item v-for="source in channels_dvr.sources" :key="source.source_name" :to="'channels/'+source.source_name" router-component-name="b-vue-inertia-link">
                                {{ source.display_name }}
                            </b-list-group-item>
                        </b-list-group>
                        <b-list-group flush v-else>
                            <b-list-group-item class="text-center">
                                <strong>No Channels DVR Server Configured</strong>
                            </b-list-group-item>
                        </b-list-group>
                    </b-card>
                </div>
                <div class="col-sm">
                    <b-card bg-variant="light" no-body>
                        <b-card-body>
                            <b-card-title title-tag="h5">External Source Providers</b-card-title>
                            <b-card-sub-title>Set channel numbers and export M3U playlists and XMLTV guide data from external source providers</b-card-sub-title>
                        </b-card-body>
                        <b-list-group flush v-if="hasSources(external_sources)">
                            <b-list-group-item v-for="source in external_sources.sources" :key="source.source_name" :to="'source/'+source.source_name" router-component-name="b-vue-inertia-link">
                                {{ source.display_name }}
                            </b-list-group-item>
                        </b-list-group>
                        <b-list-group flush v-else>
                            <b-list-group-item class="text-center">
                                <strong>No External Source Providers Configured</strong>
                            </b-list-group-item>
                        </b-list-group>
                    </b-card>
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <div class="col-sm">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Help / Instructions</h5>
                            <h6 class="card-subtitle">
                                Mapping Channel Numbers
                            </h6>
                            <p class="card-text">
                                Leave the Channel Number field empty to use the original channel number. For external sources, you can use the Starting Channel Number field to automatically number all channels starting with the entered number.
                            </p>
                            <hr/>
                            <h6 class="card-subtitle">
                                Channels DVR Sources - M3U Playlist Options
                            </h6>
                            <p class="card-text">
                                Append <code>?max_number=CHANNEL_NUMBER</code> to the playlist URL to only include channel numbers up to and including the number provided.
                            </p>
                            <hr/>
                            <h6 class="card-subtitle">
                                All Sources - XMLTV Guide Options
                            </h6>
                            <p class="card-text">
                                Append <code>?days=</code> or <code>?hours=</code> or <code>?minutes=</code> or <code>?seconds=</code> to the XMLTV guide URL to export guide data for the provided duration.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'Home',
  props: {
        title: String,
        channels_dvr: Object,
        external_sources: Object
  },
  methods: {
        hasSources: function(provider) {
            return Object.keys(provider.sources).length > 0;
        }
  },
  computed: {

  }
};
</script>