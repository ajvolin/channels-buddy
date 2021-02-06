<template>
    <div>
        <div class="container-fluid">
            <Navbar/>
            <slot/>
        </div>
    </div>
</template>

<script>
export default {
  name: 'MainLayout'
};
</script>