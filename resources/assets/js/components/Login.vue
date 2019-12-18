<template>
    <div class="container">
        <form @submit.prevent="onSubmit">
            <label><input type="email" name="email" v-model="inputText.email"></label>
            <label><input type="password" name="password" v-model="inputText.password"></label>
            <input type="submit">
        </form>
    </div>
</template>
<script>
    export default {
        name: 'login',
        data() {
            return {
                inputText: {email: '', password: ''}
            }
        },
        methods: {
            onSubmit: function () {
                axios.post('/api/auth/student/login', {
                    email: this.inputText.email,
                    password: this.inputText.password
                }).then(response => {
                    localStorage.setItem('access_token', response.data.access_token);
                    this.$router.push('/')
                })
            }
        }
    }
</script>

<style scoped>

</style>