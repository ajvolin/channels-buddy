<template>
  <inertia-link :href="to">
    <slot />
  </inertia-link>
</template>

<script>
  export default {
    name: 'BInertiaLink',
    props: ['to']
  }
</script>