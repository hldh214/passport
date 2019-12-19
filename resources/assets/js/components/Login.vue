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
        <a href="/oauth/line">Login with Line</a>
    </div>
</template>
<script>
    export default {
        created() {
            if (this.$route.query.token) {
                localStorage.setItem('token', this.$route.query.token);
            }
        },
        name: 'login',
        data() {
            return {
                inputText: {email: '', password: '', role: 'teacher'}
            }
        },
        methods: {
            onSubmit: function () {
                axios.post(`/api/auth/${this.inputText.role}/login`, {
                    email: this.inputText.email,
                    password: this.inputText.password,
                    token: localStorage.getItem('token')
                }).then(response => {
                    localStorage.setItem('access_token', response.data.access_token);
                    localStorage.setItem('role', this.inputText.role);
                    localStorage.removeItem('token');
                    this.$router.push('/')
                })
            }
        }
    }
</script>

<style scoped>

</style>