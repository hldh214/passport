<template>
    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <p>Welcome {{ this.role }} {{ name }}</p>

                    <p v-if="this.line">
                        Linked Line account: {{ this.line[this.role].name }}
                        <a href="" @click.prevent="unlink(line)">Unlink</a>
                    </p>

                    <p v-if="this.role === 'student'">teachers list</p>
                    <ul>
                        <li v-for="teacher in this.teachers">
                            {{ teacher.name }}
                            <a href="" v-if="teacher.following" @click.prevent="toggleFollow(teacher)">Unfollow</a>
                            <a href="" v-else @click.prevent="toggleFollow(teacher)">Follow</a>
                        </li>
                    </ul>

                    <p v-if="this.role === 'teacher'">followers list</p>
                    <ul>
                        <li v-for="follower in this.followers">
                            {{ follower.name }}
                        </li>
                    </ul>
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
                this.role = localStorage.getItem('role');

                if (!this.role) {
                    this.name = 'guest';
                    return;
                }

                axios.get(`/api/${this.role}/profile`).then(response => {
                    this.name = response.data.user.name;
                    this.followings = response.data.followings;
                    this.teachers = response.data.teachers;
                    this.followers = response.data.followers;
                    this.line = response.data.user.line;
                }).catch(reason => {
                    if (reason.response.status === 401) {
                        this.name = 'guest'
                    }
                });
            },
            toggleFollow(teacher) {
                axios.post(`/api/${this.role}/follow/${teacher.id}`).then(_ => {
                    teacher.following = !teacher.following;
                });
            },
            unlink(binding) {
                axios.delete(`/api/${this.role}/unlink/${binding.id}`).then(_ => {
                    this.line = null;
                });
            }
        },
        data() {
            return {
                name: '', role: '', followings: [], teachers: [], followers: [], line: null
            }
        }
    }
</script>
<style scoped>

</style>