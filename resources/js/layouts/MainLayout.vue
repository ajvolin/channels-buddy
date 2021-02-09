<template>
    <blank-layout>
        <Navbar/>
        <slot/>
    </blank-layout>
</template>

<script>
    import BlankLayout from './BlankLayout.vue';
    export default {
        components: { BlankLayout },
        name: 'MainLayout'
    };
</script>