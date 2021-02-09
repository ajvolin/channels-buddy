<template>
    <b-row class="mb-3">
        <b-col cols="12">
            <h4>Application Log</h4>
            <pre class="log-display overflow-auto text-wrap p-2 d-flex flex-column-reverse h-75 rounded" v-html="log"></pre>
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
    name: 'Log',
    props: {
        title: String,
        log: String
    }
}
</script>
<style>
    .log-display {
        background-color: #f5f5f5;
        border: 1px solid #ccc;
    }
</style>