<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <ul class="navbar-nav">
                    <router-link :to="{ name: 'welcome' }" class="nav-link">Home</router-link>
                </ul>
            </div>
        </nav>
        <main>
            <router-view/>
        </main>
    </div>
</template>
<script>
    export default {}
</script>
