<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <ul class="navbar-nav">
                    <router-link :to="{ name: 'welcome' }" class="nav-link">Home</router-link>
                    <router-link :to="{ name: 'login' }" class="nav-link" v-if="!this.isLogin()">Login</router-link>
                    <router-link :to="{ name: 'signup' }" class="nav-link" v-if="!this.isLogin()">Signup</router-link>
                    <!-- fixme: NEVER DO THIS -->
                    <a href="" @click.prevent="logout()" v-if="isLogin()">Logout</a>
                </ul>
            </div>
        </nav>
        <main>
            <router-view/>
        </main>
    </div>
</template>
<script>
    export default {
        methods: {
            isLogin() {
                return localStorage.getItem('access_token');
            },

            logout() {
                axios.get('/api/auth/student/logout').then(_ => {
                    localStorage.removeItem('access_token');
                    this.$router.go(0);
                });
            }
        }
    }
</script>
