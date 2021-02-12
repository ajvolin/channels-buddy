<template>
    <b-navbar border="dark" toggleable="md" type="light" variant="light" class="my-3 border rounded">
        <inertia-link class="navbar-brand" :href="route('home')">Channels Buddy</inertia-link>
        <b-navbar-toggle target="nav-collapse" label="Toggle navigation" />
        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <template v-for="(item, key) in items">
                    <b-nav-item
                        v-if="item.type == 'link'"
                        :key="'navbar_item_' + key"
                        :to="item.url"
                        :active="item.isActive"
                        :disabled="item.isDisabled"
                        router-component-name="b-inertia-link">
                        {{ item.text }}
                    </b-nav-item>
                    <b-nav-text
                        v-else-if="item.type == 'text'"
                        :key="'navbar_item_' + key">
                        {{ item.text }}
                    </b-nav-text>
                    <b-nav-item-dropdown
                        v-else-if="item.type == 'dropdown'"
                        :key="'navbar_item_' + key"
                        :text="item.text">
                        <b-dropdown-item
                            v-for="(dd_item, dd_key) in item.items"
                            :key="'navbar_item_' + key + '_dropdown_item_' + dd_key"
                            :to="dd_item.url"
                            :active="dd_item.isActive"
                            :disabled="dd_item.isDisabled"
                            router-component-name="b-inertia-link">
                            {{ dd_item.text}}
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                </template>
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
                <inertia-link :href="route('log')" class="nav-link">Log</inertia-link>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
    export default {
        name: 'Navbar',
        props: {
            items: Array
        }
    };
</script>