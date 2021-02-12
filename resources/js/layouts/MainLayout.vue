<template>
    <blank-layout>
        <Navbar :items="navbarItems" />
        <slot/>
    </blank-layout>
</template>

<script>
    import BlankLayout from './BlankLayout.vue';
    export default {
        components: { BlankLayout },
        name: 'MainLayout',
        props: {
            navbarItems: Array
        }
    };
</script>