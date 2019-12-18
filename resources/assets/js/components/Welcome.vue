<template>
    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <p>Welcome {{ name }}</p>
                    <p v-if="this.role === 'student'">teacher list</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        created() {
            this.getUser();
        },
        methods: {
            getUser() {
                let role = localStorage.getItem('role');

                if (!role) {
                    this.name = 'guest';
                    return;
                }

                axios.get(`/api/${role}/profile`).then(response => {
                    this.name = response.data.user.name;
                }).catch(reason => {
                    if (reason.response.status === 401) {
                        this.name = 'guest'
                    }
                });
            }
        },
        data() {
            return {
                name: ''
            }
        }
    }
</script>
<style scoped>

</style>