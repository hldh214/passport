<template>
    <div class="container">
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" v-model="inputText.email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" v-model="inputText.password">
            </div>
            <div class="radio">
                <label for="student">
                    <input type="radio" name="role" id="student" value="student" v-model="inputText.role">
                    I am a student
                </label>
            </div>
            <div class="radio">
                <label for="teacher">
                    <input type="radio" name="role" id="teacher" value="teacher" v-model="inputText.role">
                    I am a teacher
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/oauth/line" v-if="!this.token" role="button" class="btn btn-success">
                Login with Line
            </a>
        </form>

        <div v-if="this.token">
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