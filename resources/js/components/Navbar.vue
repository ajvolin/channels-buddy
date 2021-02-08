<template>
    <nav border="dark" class="my-3 border rounded navbar navbar-expand-lg navbar-light bg-light">
        <inertia-link class="navbar-brand" href="/home">Channels Buddy</inertia-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <div class="w-100 navbar-nav">
                <div class="flex-grow-1"></div>
                <a href="/log" class="nav-link">Log</a>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
name: 'Navbar',
};
</script>