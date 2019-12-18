<template>
    <div class="container">
        <form @submit.prevent="onSubmit">
            <label for="name">Name:
                <input id="name" type="text" name="name" v-model="inputText.name">
            </label>
            <label for="email">Email:
                <input id="email" type="email" name="email" v-model="inputText.email">
            </label>
            <label for="password">Password:
                <input id="password" type="password" name="password" v-model="inputText.password">
            </label>
            <label for="password_confirmation">Password Confirm:
                <input id="password_confirmation" type="password" name="password"
                       v-model="inputText.password_confirmation">
            </label>
            <label for="student">I am student
                <input id="student" type="radio" name="role" value="student" v-model="inputText.role">
            </label>
            <label for="teacher">I am teacher
                <input id="teacher" type="radio" name="role" value="teacher" v-model="inputText.role">
            </label>
            <input type="submit">
        </form>
    </div>
</template>
<script>
    export default {
        name: 'signup',
        data() {
            return {
                inputText: {
                    name: '', email: '', password: '', password_confirmation: '', role: 'teacher'
                }
            }
        },
        methods: {
            onSubmit: function () {
                axios.post(`/api/auth/${this.inputText.role}/signup`, {
                    name: this.inputText.name,
                    email: this.inputText.email,
                    password: this.inputText.password,
                    password_confirmation: this.inputText.password_confirmation
                }).then(response => {
                    console.log(response);
                    this.$router.push('/login')
                }).catch(reason => {
                    let data = reason.response.data;
                    console.log(data);
                })
            }
        }
    }
</script>

<style scoped>

</style>