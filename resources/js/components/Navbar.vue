<template>
    <nav border="dark" class="mb-3 border rounded navbar navbar-expand-lg navbar-light bg-light" style="margin-top: 1em;">
        <a class="navbar-brand" href="/">Channels Buddy</a>
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