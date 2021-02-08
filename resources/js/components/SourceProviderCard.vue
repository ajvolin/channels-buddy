<template>
    <b-card bg-variant="light" no-body>
        <b-card-body>
            <b-card-title title-tag="h5">{{ title }}</b-card-title>
            <b-card-sub-title>{{ subtitle }}</b-card-sub-title>
        </b-card-body>
        <b-list-group flush v-if="hasSources(sourceProvider)">
            <b-list-group-item v-for="source in sourceProvider" :key="source.source_name" :to="route(sourceRoute, source.source_name)" router-component-name="b-inertia-link">
                {{ source.display_name }}
            </b-list-group-item>
        </b-list-group>
        <b-list-group flush v-else>
            <b-list-group-item class="text-center">
                <strong>{{ noSourcesMessage }}</strong>
            </b-list-group-item>
        </b-list-group>
    </b-card>
</template>

<script>
export default {
    name: 'SourceProviderCard',
    props: {
        title: String,
        subtitle: String,
        noSourcesMessage: String,
        sourceProvider: Array,
        sourceRoute: String
    },
    methods: {
        hasSources: function(provider) {
            return provider.length > 0;
        }
    }
}
</script>