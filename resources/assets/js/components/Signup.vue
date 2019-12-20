<template>
    <div class="container">
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" class="form-control" v-model="inputText.name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control" v-model="inputText.email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" v-model="inputText.password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Password Confirm</label>
                <input id="password_confirmation" type="password" name="password"
                       class="form-control" v-model="inputText.password_confirmation">
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
                }).then(_ => {
                    this.$router.push('/login')
                })
            }
        }
    }
</script>

<style scoped>

</style>