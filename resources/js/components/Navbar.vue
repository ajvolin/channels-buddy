<template>
    <b-navbar border="dark" toggleable="md" type="light" variant="light" class="my-3 border rounded">
        <inertia-link class="navbar-brand" :href="route('home')">Channels Buddy</inertia-link>
        <b-navbar-toggle target="nav-collapse" label="Toggle navigation" />
        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <!-- -->
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
                <inertia-link :href="route('log')" class="nav-link">Log</inertia-link>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
    export default {
        name: 'Navbar'
    };
</script>