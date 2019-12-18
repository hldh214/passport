<template>
    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Welcome {{ name }}
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

                axios.get(`/api/${role}/profile`).then(response => {
                    this.name = response.data.name;
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