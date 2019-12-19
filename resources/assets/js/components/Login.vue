<template>
    <div class="container">
        <form @submit.prevent="onSubmit">
            <label for="email">Email:
                <input id="email" type="email" name="email" v-model="inputText.email">
            </label>
            <label for="password">Password:
                <input id="password" type="password" name="password" v-model="inputText.password">
            </label>
            <label for="student">I am student
                <input id="student" type="radio" name="role" value="student" v-model="inputText.role">
            </label>
            <label for="teacher">I am teacher
                <input id="teacher" type="radio" name="role" value="teacher" v-model="inputText.role">
            </label>
            <input type="submit">
        </form>
        <a href="/oauth/line" v-if="!this.token">Login with Line</a>
        <div v-else>
            <p>Login to bind your account or choose one below</p>
            <ul>
                <li v-for="binding in this.bindings">
                    {{ binding }}
                    <a href="" @click.prevent="loginWithBinding(binding)">Login</a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        created() {
            if (this.$route.query.token) {
                localStorage.setItem('token', this.$route.query.token);
            }

            this.token = localStorage.getItem('token');

            if (this.token) {
                this.queryBindings();
            }
        },
        name: 'login',
        data() {
            return {
                inputText: {email: '', password: '', role: 'teacher'},
                token: null,
                bindings: []
            }
        },
        methods: {
            onSubmit: function () {
                axios.post(`/api/auth/${this.inputText.role}/login`, {
                    email: this.inputText.email,
                    password: this.inputText.password,
                    token: this.token
                }).then(response => {
                    localStorage.setItem('access_token', response.data.access_token);
                    localStorage.setItem('role', this.inputText.role);
                    localStorage.removeItem('token');
                    this.token = null;
                    this.$router.push('/')
                })
            },
            queryBindings: function () {
                axios.post(`/api/auth/line/query_bindings`, {
                    token: this.token
                }).then(response => {
                    this.bindings = response.data;
                })
            },
            loginWithBinding: function (binding) {
                axios.post(`/api/auth/line/login_with_binding`, {
                    type: binding.type,
                    id: binding.id,
                    token: this.token
                }).then(response => {
                    localStorage.setItem('access_token', response.data.access_token);
                    localStorage.setItem('role', binding.type);
                    localStorage.removeItem('token');
                    this.token = null;
                    this.$router.push('/')
                })
            }
        }
    }
</script>

<style scoped>

</style>